<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Services\RecommendationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RecommendationController extends Controller
{
    public function __construct(private RecommendationService $service)
    {
    }

    /**
     * Personalized recommendations for the authenticated user.
     */
    public function forUser(Request $request)
    {
        $limit = (int) ($request->get('limit', 12));
        $user = Auth::user();
        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        $books = $this->service->recommendForUser($user, $limit);
        return response()->json([
            'data' => $books->map(fn($b) => $this->serializeBook($b)),
        ]);
    }

    /**
     * Books similar to a given book (content-based only).
     */
    public function similarToBook(Request $request, Book $book)
    {
        $limit = (int) ($request->get('limit', 8));
        $books = $this->service->similarToBook($book, $limit);
        return response()->json([
            'data' => $books->map(fn($b) => $this->serializeBook($b)),
        ]);
    }

    private function serializeBook(Book $book): array
    {
        $discountPercent = $book->price > 0 ? round((($book->price - $book->final_price) / $book->price) * 100) : 0;
        
        return [
            'id' => $book->id,
            'title' => $book->title,
            'author' => $book->author,
            'price' => $book->price,
            'final_price' => $book->final_price,
            'is_on_sale' => $book->is_on_sale,
            'discount_percent' => $discountPercent,
            'in_wishlist' => Auth::check() ? Auth::user()->hasBookInWishlist($book->id) : false,
            'genre' => $book->genre?->name,
            'tropes' => $book->tropes->pluck('name')->values(),
            'cover_image' => $book->cover_image ? asset('storage/'.$book->cover_image) : null,
            'condition' => $book->condition ?? 'new',
            'score' => $book->score ?? null,
            'stock' => $book->stock,
            'link' => route('books.show', $book, absolute: false),
        ];
    }
}


