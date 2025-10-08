# Review Images Feature

## Overview
Added photo upload functionality to customer reviews, similar to Shopee and TikTok Shop. Customers can now upload up to 5 images with their reviews, creating a visual gallery experience.

## Features Added

### 1. Database Changes
- Added `images` JSON column to `reviews` table
- Migration: `add_images_to_reviews_table.php`

### 2. Model Updates
- Updated `Review` model with:
  - `images` in fillable array
  - `images` cast as array
  - `getImageUrlsAttribute()` - returns full URLs for images
  - `hasImages()` - checks if review has images
  - `getFirstImageUrlAttribute()` - gets first image URL for thumbnails

### 3. Controller Updates
- Updated `ReviewController@store` to handle image uploads
- Added validation for image files (max 2MB each, max 5 images)
- Images stored in `storage/app/public/reviews/` directory

### 4. Frontend Features

#### Review Form
- Drag & drop image upload area
- Image preview gallery with remove functionality
- File validation (type, size, count)
- Responsive grid layout for previews

#### Review Display
- Image gallery grid for each review
- Click to open full-size modal viewer
- Thumbnail navigation
- Keyboard navigation (arrow keys, escape)
- Responsive design

#### Image Modal
- Full-screen image viewer
- Previous/Next navigation
- Thumbnail strip at bottom
- Click outside to close
- Keyboard shortcuts

## Usage

### For Customers
1. When writing a review, drag & drop images or click to upload
2. Preview images before submitting
3. Remove unwanted images
4. Submit review with photos

### For Viewers
1. Click on any review image to open full-size viewer
2. Navigate between images using arrows or thumbnails
3. Use keyboard shortcuts for navigation
4. Click outside modal to close

## Technical Details

### File Storage
- Images stored in `storage/app/public/reviews/`
- Public access via `storage` symlink
- Automatic file naming by Laravel

### Validation
- File types: JPEG, PNG, JPG, GIF
- Max size: 2MB per image
- Max count: 5 images per review
- Client-side and server-side validation

### Security
- File type validation
- Size limits
- Storage in public directory with proper permissions

## Future Enhancements
- Image compression/optimization
- Multiple image formats support
- Admin moderation for review images
- Image lazy loading
- Progressive image loading

