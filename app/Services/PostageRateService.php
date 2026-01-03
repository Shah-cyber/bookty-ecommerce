<?php

namespace App\Services;

use App\Models\PostageRate;
use App\Models\PostageRateHistory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class PostageRateService
{
    /**
     * Update postage rate and create history record
     * This implements the hybrid approach: updates current rate and creates immutable history
     * 
     * @param string $region Region code (sm, sabah, sarawak, labuan)
     * @param float $newCustomerPrice New price to charge customers
     * @param float $newActualCost New actual shipping cost
     * @param string|null $comment Optional comment explaining the change
     * @param int|null $userId User ID making the change (defaults to authenticated user)
     * @return PostageRateHistory The created history record
     */
    public function updateRate(
        string $region,
        float $newCustomerPrice,
        float $newActualCost,
        ?string $comment = null,
        ?int $userId = null
    ): PostageRateHistory {
        return DB::transaction(function () use (
            $region, 
            $newCustomerPrice, 
            $newActualCost, 
            $comment, 
            $userId
        ) {
            $rate = PostageRate::where('region', $region)->firstOrFail();
            
            // Check if price actually changed
            $priceChanged = $rate->customer_price != $newCustomerPrice 
                         || $rate->actual_cost != $newActualCost;
            
            if (!$priceChanged) {
                // Return current history if no change
                $currentHistory = $rate->currentHistory;
                
                if (!$currentHistory) {
                    // Create initial history if it doesn't exist
                    $currentHistory = $this->createInitialHistory($rate, $userId);
                }
                
                return $currentHistory;
            }
            
            $now = Carbon::now();
            
            // 1. Close current history record (set valid_until)
            PostageRateHistory::where('postage_rate_id', $rate->id)
                ->whereNull('valid_until')
                ->update(['valid_until' => $now]);
            
            // 2. Create new history record (immutable)
            $history = PostageRateHistory::create([
                'postage_rate_id' => $rate->id,
                'customer_price' => $newCustomerPrice,
                'actual_cost' => $newActualCost,
                'updated_by' => $userId ?? auth()->id(),
                'comment' => $comment,
                'valid_from' => $now,
                'valid_until' => null, // Current/active record
            ]);
            
            // 3. Update current rate in postage_rates table
            $rate->update([
                'customer_price' => $newCustomerPrice,
                'actual_cost' => $newActualCost,
            ]);
            
            Log::info("Postage rate updated for region: {$region}", [
                'old_customer_price' => $rate->getOriginal('customer_price'),
                'new_customer_price' => $newCustomerPrice,
                'old_actual_cost' => $rate->getOriginal('actual_cost'),
                'new_actual_cost' => $newActualCost,
                'updated_by' => $userId ?? auth()->id(),
                'comment' => $comment,
            ]);
            
            return $history;
        });
    }
    
    /**
     * Get current active history record for a region
     * 
     * @param string $region Region code
     * @return PostageRateHistory|null Current history record or null
     */
    public function getCurrentHistory(string $region): ?PostageRateHistory
    {
        return PostageRateHistory::forRegion($region)
            ->current()
            ->first();
    }
    
    /**
     * Get rate that was valid at a specific datetime
     * Useful for historical analysis and verification
     * 
     * @param string $region Region code
     * @param Carbon $datetime DateTime to check
     * @return PostageRateHistory|null History record valid at that time
     */
    public function getRateAt(string $region, Carbon $datetime): ?PostageRateHistory
    {
        return PostageRateHistory::forRegion($region)
            ->validAt($datetime)
            ->first();
    }
    
    /**
     * Get price history timeline for a region
     * Returns chronological list of all price changes
     * 
     * @param string $region Region code
     * @param int $limit Maximum number of records to return
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getHistoryTimeline(string $region, int $limit = 20)
    {
        return PostageRateHistory::forRegion($region)
            ->with('updater')
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }
    
    /**
     * Get all price history across all regions
     * 
     * @param int $limit Maximum number of records
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllHistory(int $limit = 50)
    {
        return PostageRateHistory::with(['postageRate', 'updater'])
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }
    
    /**
     * Initialize history for existing rates
     * Run this once after adding the history table to migrate existing data
     * 
     * @return int Number of history records created
     */
    public function initializeHistory(): int
    {
        $count = 0;
        
        DB::transaction(function () use (&$count) {
            foreach (PostageRate::all() as $rate) {
                // Check if history already exists
                if ($rate->history()->exists()) {
                    continue;
                }
                
                // Create initial history record
                $this->createInitialHistory($rate);
                $count++;
            }
        });
        
        Log::info("Initialized postage rate history", ['records_created' => $count]);
        
        return $count;
    }
    
    /**
     * Create initial history record for a rate
     * 
     * @param PostageRate $rate The postage rate
     * @param int|null $userId User ID (defaults to system user)
     * @return PostageRateHistory Created history record
     */
    protected function createInitialHistory(PostageRate $rate, ?int $userId = null): PostageRateHistory
    {
        return PostageRateHistory::create([
            'postage_rate_id' => $rate->id,
            'customer_price' => $rate->customer_price,
            'actual_cost' => $rate->actual_cost,
            'updated_by' => $userId ?? 1, // System user
            'comment' => 'Initial rate from existing data',
            'valid_from' => $rate->created_at ?? now(),
            'valid_until' => null,
        ]);
    }
    
    /**
     * Get statistics about rate changes
     * 
     * @param string|null $region Optional region filter
     * @return array Statistics
     */
    public function getStatistics(?string $region = null): array
    {
        $query = PostageRateHistory::query();
        
        if ($region) {
            $query->forRegion($region);
        }
        
        $totalChanges = $query->count();
        $currentRates = PostageRateHistory::current()->count();
        
        return [
            'total_changes' => $totalChanges,
            'current_rates' => $currentRates,
            'total_regions' => PostageRate::count(),
            'history_per_region' => PostageRate::withCount('history')->get()
                ->pluck('history_count', 'region')
                ->toArray(),
        ];
    }
    
    /**
     * Verify data integrity
     * Check if denormalized order prices match their history records
     * 
     * @return array Verification results
     */
    public function verifyDataIntegrity(): array
    {
        $orders = \App\Models\Order::whereNotNull('postage_rate_history_id')
            ->with('postageRateHistory')
            ->get();
        
        $mismatches = [];
        
        foreach ($orders as $order) {
            if (!$order->verifyShippingPrice()) {
                $mismatches[] = [
                    'order_id' => $order->id,
                    'public_id' => $order->public_id,
                    'order_price' => $order->shipping_customer_price,
                    'history_price' => $order->postageRateHistory->customer_price,
                ];
            }
        }
        
        return [
            'total_orders_checked' => $orders->count(),
            'mismatches_found' => count($mismatches),
            'integrity_ok' => count($mismatches) === 0,
            'mismatches' => $mismatches,
        ];
    }
}
