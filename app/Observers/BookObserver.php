<?php

namespace App\Observers;

use App\Models\Book;
use Illuminate\Support\Facades\Cache;

class BookObserver
{
    /**
     * Handle the Book "created" event.
     */
    public function created(Book $book): void
    {
        $this->clearRecommendationCaches();
    }

    /**
     * Handle the Book "updated" event.
     */
    public function updated(Book $book): void
    {
        // Clear similar books cache for this specific book
        $this->clearSimilarBooksCache($book->id);
        
        // Clear all recommendation caches since book data changed
        $this->clearRecommendationCaches();
    }

    /**
     * Handle the Book "deleted" event.
     */
    public function deleted(Book $book): void
    {
        // Clear similar books cache for deleted book
        $this->clearSimilarBooksCache($book->id);
        
        // Clear all recommendation caches
        $this->clearRecommendationCaches();
    }

    /**
     * Handle the Book "restored" event.
     */
    public function restored(Book $book): void
    {
        $this->clearRecommendationCaches();
    }

    /**
     * Handle the Book "force deleted" event.
     */
    public function forceDeleted(Book $book): void
    {
        $this->clearSimilarBooksCache($book->id);
        $this->clearRecommendationCaches();
    }
    
    /**
     * Clear similar books cache for a specific book.
     */
    private function clearSimilarBooksCache(int $bookId): void
    {
        // Clear common limit variations
        $limits = [6, 8, 12];
        foreach ($limits as $limit) {
            Cache::forget("reco:similar:{$bookId}:v1:{$limit}");
        }
    }
    
    /**
     * Clear all recommendation caches.
     * Note: User-specific caches will expire naturally in 30 minutes.
     * For immediate updates, users can hard refresh (Ctrl+F5).
     */
    private function clearRecommendationCaches(): void
    {
        try {
            // If using cache tags (Redis/Memcached), clear by tag
            try {
                Cache::tags(['recommendations'])->flush();
            } catch (\Exception $e) {
                // Tags not supported by cache driver, continue
                // Cache will expire naturally in 30 minutes
            }
        } catch (\Exception $e) {
            // Cache clearing failed, but continue anyway
            // The cache will expire naturally in 30 minutes
        }
    }
}
