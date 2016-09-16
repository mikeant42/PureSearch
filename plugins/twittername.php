<?php
require_once('pluginfuncs.php');
require_once('twitter-api.php');
function ini_twittername($search) {
	if (preg_match('/(?<=^|(?<=[^a-zA-Z0-9-\.]))@([A-Za-z_]+[A-Za-z0-9_]+)/', $search, $matches)) {
				$twitter_username = '@' . $matches[1];
				$twitter_username = trim(escapeHTML($twitter_username));
				$twitter_url = "https://www.twitter.com/$twitter_username";
				
				$settings = array(
					'oauth_access_token' => "1686575688-HhvW1vPMYQpRJZqTMyLHrB7cQQ3gqTpJkNjyCxb",
					'oauth_access_token_secret' => "2BTFlc6rz8p6Me5wNa6zRiTk0OQ4LO2YZJwOIeQHvI",
					'consumer_key' => "OMMmimXsWbNJI3ZK2drF6g",
					'consumer_secret' => "adz0GmJ5U8vknxfWQbPEKXweKhM9SUgoNN6iGwOqt68"
				);
				$requestMethod = "GET";
				$personal_twitter_url = 'https://api.twitter.com/1.1/statuses/user_timeline.json';
				$getfield = "?screen_name=" . str_replace('@', '', $twitter_username) . "&count=1";
				$requestMethod = 'GET';
				$twitter = new TwitterAPIExchange($settings);
				$twitter_info = $twitter->setGetfield($getfield)
							 ->buildOauth($personal_twitter_url, $requestMethod)
							 ->performRequest();
				
				
				$twitter_info_new = json_decode($twitter_info, true);
				
				
				
				echo space() . "<div class='definition-box'><span class='definition'>
				<a href='$twitter_url' style='font-size: 25px; text-align: center;'>$twitter_username</a>
				<ul>
					";
					
					$profile_picture[] = array(); // 8
					$last_tweet = "";
					$i = 0;
					$profile_number = 0;
					foreach ($twitter_info_new as $item) {
						if (empty($item)) {
							echo 'the user doesnt exist';
						} else {
							foreach ($item as $new_item) {
								$i++;
								@$profile_picture[] = $new_item['profile_image_url'];
								//echo $i . ' |';
								@$tweet = (String) $new_item;
								$tweet = str_replace('Arrayen', '', $tweet);
								$tweet = preg_replace('/(?<=^|(?<=[^a-zA-Z0-9-\.]))#([A-Za-z_]+[A-Za-z0-9_]+)/', '<a href="https://twitter.com/search?q=$1&src=hash" rel="nofollow">#$1</a>', $tweet);
								$tweet = preg_replace('/(?<=^|(?<=[^a-zA-Z0-9-\.]))@([A-Za-z_]+[A-Za-z0-9_]+)/', '<a href="https://twitter.com/$1" rel="nofollow">@$1</a>', $tweet);
								echo $tweet;
							}
					}
				}
					
					echo "
				</ul>
				<img src='". $profile_picture[12] ."' style='float: right;'>
				</span></div>";
			}
}
			
?>