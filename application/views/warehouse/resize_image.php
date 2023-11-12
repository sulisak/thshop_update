<?php
// Get the image file path from the query string parameter
$imagePath = $_GET['image'];

// Define the maximum width for the resized image
$maxWidth = 800;

// Load the image using GD or Imagick library
$image = imagecreatefromstring(file_get_contents($imagePath));

// Get the original dimensions of the image
$originalWidth = imagesx($image);
$originalHeight = imagesy($image);

// Calculate the new dimensions while maintaining the aspect ratio
$newWidth = $originalWidth > $maxWidth ? $maxWidth : $originalWidth;
$newHeight = ($newWidth / $originalWidth) * $originalHeight;

// Create a new image resource with the desired dimensions
$resizedImage = imagecreatetruecolor($newWidth, $newHeight);

// Resize the original image to the new dimensions
imagecopyresampled($resizedImage, $image, 0, 0, 0, 0, $newWidth, $newHeight, $originalWidth, $originalHeight);

// Set the appropriate header for the resized image
header('Content-Type: image/jpeg');

// Output the resized image to the browser
imagejpeg($resizedImage, null, 80); // Adjust the image quality (80 in this example)

// Clean up resources
imagedestroy($image);
imagedestroy($resizedImage);
?>