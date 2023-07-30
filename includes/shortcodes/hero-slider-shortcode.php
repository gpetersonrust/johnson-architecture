<?php
// 
class GP_Johnson_Architecture {

    private $home_images = [];
    private $home_images_IDs = [];
    private $images_loaded = [];

    // Constructor
    public function __construct() {
        $this->generateHomeImages();
        $this->fetchAndUpdateACF();
    }

    // Generate the $home_images array using WP_Query
    private function generateHomeImages() {
        $home_images_array = [];
        $args = array(
            'post_type' => 'home_images',
            'posts_per_page' => -1,
            'post_status' => 'publish',
            'orderby' => 'date',
            'order' => 'ASC',
        );

        $home_images = new WP_Query($args);

        if ($home_images->have_posts()) {
            while ($home_images->have_posts()) {
                $home_images->the_post();
                $home_images_array[] = array(
                    'ID' => get_the_ID(),
                    'title' =>    get_the_title(),
                    'thumbnail' => get_the_post_thumbnail_url(null, 'full'),
                    'subheadline' => strip_tags(get_the_content()),
                    'portfolio_link' => get_field('portfolio_link'),
                    'slider_logo' => get_field('slider_logo'),
                );
               ;
            }

           
        }

        // Reset the post data after the loop
        wp_reset_postdata();

        $this->home_images = $home_images_array;
        $this->home_images_IDs = array_map(function($image) {
            return $image['ID'];
        }, $this->home_images);
    }

    // Initialize the GP_Johnson_Architecture class and sets up the image loading logic.
    public function init() {
        $this->fetchAndUpdateACF();
        $this->randomlySelectImage();
    }

    // Randomly selects an image from the home_images array and loads it if not already loaded.
    public function randomlySelectImage() {
        // Get a random image from the home images array
        $random_image = $this->home_images[array_rand($this->home_images)];

        // Check if ACF field is full; if so, reset it, otherwise load the image
        if ($this->isACFFieldFull()) {
            $this->resetACFField();
        } else {
            $this->loadImage($random_image);
        }
      return $this;
       
    }

    // Loads the specified image by adding its ID to the images_loaded array and updating the ACF field.
    public function loadImage($image) {
        // Add the image ID to the images loaded array
        $this->images_loaded[] = $image['ID'];
        // Update ACF field
        $this->updateACFField();
        // Load the image (implement the image loading logic here)
        $this->heroBannerHTML($image);
    }

    // Implement this method to generate the HTML for the hero banner using the image object.
    public function heroBannerHTML($image) {
        ob_start(); // Start output buffering to capture the HTML content
           
        // Include the template file  from templates folder which is adjacent to the parent folder of this file
        include plugin_dir_path( dirname( __FILE__ ) ) . 'templates/hero-slider-template.php';

        $this->html = ob_get_clean(); // Get the captured HTML and clean the buffer
     
    }

   

    // Checks if the specified image is already loaded.
    public function isImageLoaded($image) {
        // Check if the image ID is in the images loaded array
        return in_array($image['ID'], $this->images_loaded);
    }

    // Checks if the ACF field is full, meaning all images are already loaded.
    public function isACFFieldFull() {
        return count($this->images_loaded) === count($this->home_images);
    }

    // Resets the images_loaded array and updates the ACF field.
    public function resetACFField() {
        $this->images_loaded = [];
        $this->updateACFField();
    }

    // Fetches the images_loaded value from the ACF field and updates the class's images_loaded array.
    // If images_loaded length is equal to the home images length, the array is reset.
    // If no images-loaded value is found in the ACF field, it initializes the ACF field with an empty array.
    public function fetchAndUpdateACF() {
        // Fetch the images-loaded value from ACF
        $images_loaded = get_field('loaded_images');
        $this->images_loaded = $images_loaded ? $images_loaded : [];
        // If images loaded length is equal to the home images length, reset the array
        if ($this->isACFFieldFull()) {
            $this->resetACFField();
        }
    }

    // Updates the ACF field with the current images_loaded array.
    public function updateACFField() {
        update_field('loaded_images', $this->images_loaded, 'options');
    }

    // Hypothetical method to get a random image from the home images array.
    public function getRandomImage() {
        return $this->home_images[array_rand($this->home_images)];
    }
}

// Instantiate the GP_Johnson_Architecture class



function dynamic_slider_shortcode(){
    $gp_johnson_architecture = new GP_Johnson_Architecture();

// Initialize the GP_Johnson_Architecture class
$gp_johnson_architecture->init();
//  print html
 return $gp_johnson_architecture->html;

}

