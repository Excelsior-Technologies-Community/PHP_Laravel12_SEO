<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'image',
        'meta_title',
        'meta_description',
        'focus_keyword',
    ];

    /**
     * Use slug instead of ID for product URLs.
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Calculate SEO score for the product.
     *
     * Maximum score: 100
     */
    public function getSeoScoreAttribute(): int
    {
        $score = 0;

        // 1. Meta title exists
        if (!empty($this->meta_title)) {
            $score += 15;
        }

        // 2. Meta title length is SEO-friendly
        if (
            !empty($this->meta_title) &&
            strlen($this->meta_title) >= 30 &&
            strlen($this->meta_title) <= 60
        ) {
            $score += 10;
        }

        // 3. Meta description exists
        if (!empty($this->meta_description)) {
            $score += 15;
        }

        // 4. Meta description length is SEO-friendly
        if (
            !empty($this->meta_description) &&
            strlen($this->meta_description) >= 120 &&
            strlen($this->meta_description) <= 160
        ) {
            $score += 10;
        }

        // 5. Focus keyword exists
        if (!empty($this->focus_keyword)) {
            $score += 10;
        }

        // 6. Keyword appears in product name
        if (
            !empty($this->focus_keyword) &&
            stripos($this->name, $this->focus_keyword) !== false
        ) {
            $score += 10;
        }

        // 7. Keyword appears in description
        if (
            !empty($this->focus_keyword) &&
            stripos($this->description, $this->focus_keyword) !== false
        ) {
            $score += 10;
        }

        // 8. SEO-friendly slug
        if (!empty($this->slug)) {
            $score += 5;
        }

        // 9. Product image exists
        if (!empty($this->image)) {
            $score += 5;
        }

        // 10. Product description exists
        if (!empty($this->description)) {
            $score += 5;
        }

        return min($score, 100);
    }

    /**
     * Get SEO score label.
     */
    public function getSeoScoreLabelAttribute(): string
    {
        $score = $this->seo_score;

        if ($score >= 80) {
            return 'Excellent';
        }

        if ($score >= 60) {
            return 'Good';
        }

        if ($score >= 40) {
            return 'Needs Improvement';
        }

        return 'Poor';
    }
}