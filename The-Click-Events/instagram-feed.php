<?php
// Instagram Feed API Integration
// This script fetches Instagram posts using the Basic Display API

class InstagramFeed {
    private $accessToken;
    private $userId;
    private $cacheFile = 'instagram_cache.json';
    private $cacheDuration = 3600; // 1 hour cache
    
    public function __construct($accessToken, $userId) {
        $this->accessToken = $accessToken;
        $this->userId = $userId;
    }
    
    public function getFeed() {
        // Check cache first
        if ($this->isCacheValid()) {
            return $this->getCachedData();
        }
        
        // Fetch fresh data from Instagram API
        $data = $this->fetchFromAPI();
        
        if ($data) {
            $this->saveToCache($data);
            return $data;
        }
        
        // Return cached data if API fails
        return $this->getCachedData();
    }
    
    private function fetchFromAPI() {
        $url = "https://graph.instagram.com/{$this->userId}/media?fields=id,caption,media_url,permalink,media_type,thumbnail_url,timestamp&access_token={$this->accessToken}&limit=4";
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        if ($httpCode === 200) {
            return json_decode($response, true);
        }
        
        return null;
    }
    
    private function isCacheValid() {
        if (!file_exists($this->cacheFile)) {
            return false;
        }
        
        $cacheTime = filemtime($this->cacheFile);
        return (time() - $cacheTime) < $this->cacheDuration;
    }
    
    private function getCachedData() {
        if (file_exists($this->cacheFile)) {
            $cached = file_get_contents($this->cacheFile);
            return json_decode($cached, true);
        }
        return null;
    }
    
    private function saveToCache($data) {
        file_put_contents($this->cacheFile, json_encode($data));
    }
    
    public function renderFeed() {
        $feed = $this->getFeed();
        
        if (!$feed || !isset($feed['data'])) {
            return $this->renderFallback();
        }
        
        $output = '<div class="row">';
        
        foreach (array_slice($feed['data'], 0, 4) as $post) {
            $imageUrl = $post['media_type'] === 'VIDEO' ? $post['thumbnail_url'] : $post['media_url'];
            $permalink = $post['permalink'];
            $caption = isset($post['caption']) ? $post['caption'] : 'Click Events Instagram Post';
            
            // Truncate caption for display
            $shortCaption = strlen($caption) > 50 ? substr($caption, 0, 50) . '...' : $caption;
            
            $output .= '
            <div class="col-lg-3 col-md-3 col-sm-6">
                <figure class="mb-0 insta-section-imgs">
                    <img src="' . htmlspecialchars($imageUrl) . '" alt="' . htmlspecialchars($shortCaption) . '" class="img-fluid">
                    <div class="hover_box_plus">
                        <a href="' . htmlspecialchars($permalink) . '" target="_blank" rel="noopener">
                            <i class="fa-brands fa-instagram"></i>Click Events
                        </a>
                    </div>
                </figure>
            </div>';
        }
        
        $output .= '</div>';
        return $output;
    }
    
    private function renderFallback() {
        // Fallback to existing static images if API fails
        return '
        <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-6">
                <figure class="mb-0 insta-section-imgs">
                    <img src="./assets/images/insta-section-img1.png" alt="" class="img-fluid">
                    <div class="hover_box_plus">
                        <a href="https://www.instagram.com/the_click_events/" target="_blank" class="text-decoration-none">
                            <i class="fa-brands fa-instagram"></i>Click Events
                        </a>
                    </div>
                </figure>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6">
                <figure class="mb-0 insta-section-imgs">
                    <img src="./assets/images/insta-section-img2.png" alt="" class="img-fluid">
                    <div class="hover_box_plus">
                        <a href="https://www.instagram.com/the_click_events/" target="_blank" class="text-decoration-none">
                            <i class="fa-brands fa-instagram"></i>Click Events
                        </a>
                    </div>
                </figure>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6">
                <figure class="mb-0 insta-section-imgs insta-section-imgs-mb">
                    <img src="./assets/images/insta-section-img3.png" alt="" class="img-fluid">
                    <div class="hover_box_plus">
                        <a href="https://www.instagram.com/the_click_events/" target="_blank" class="text-decoration-none">
                            <i class="fa-brands fa-instagram"></i>Click Events
                        </a>
                    </div>
                </figure>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6">
                <figure class="mb-0 insta-section-imgs insta-section-imgs-mb">
                    <img src="./assets/images/insta-section-img4.png" alt="" class="img-fluid">
                    <div class="hover_box_plus">
                        <a href="https://www.instagram.com/the_click_events/" target="_blank" class="text-decoration-none">
                            <i class="fa-brands fa-instagram"></i>Click Events
                        </a>
                    </div>
                </figure> 
            </div>
        </div>';
    }
}

// Configuration
$instagramAccessToken = 'YOUR_INSTAGRAM_ACCESS_TOKEN'; // Replace with your actual token
$instagramUserId = '17841400000000000'; // Replace with your actual Instagram User ID

// Check if configuration is set
if ($instagramAccessToken === 'YOUR_INSTAGRAM_ACCESS_TOKEN' || $instagramUserId === '17841400000000000') {
    // Configuration not set, use fallback
    $instagramFeed = null;
} else {
    $instagramFeed = new InstagramFeed($instagramAccessToken, $instagramUserId);
}
?>
