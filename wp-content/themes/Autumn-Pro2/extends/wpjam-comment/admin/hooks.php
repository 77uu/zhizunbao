<?php
add_filter('wp_count_comments', function($stats, $post_id){
	if($post_id){
		return $stats;
	}

	$cache_key		= 'comment_stats:'.wp_cache_get_last_changed('comment');
	$stats_object	= wp_cache_get($cache_key, 'comment');

	if($stats_object === false){
		global $wpdb;

		$where	= "WHERE comment_type != 'fav'";
		$totals	= (array)$wpdb->get_results("SELECT comment_approved, COUNT( * ) AS total FROM {$wpdb->comments} {$where} GROUP BY comment_approved", ARRAY_A);

		$stats	= [
			'approved'			=> 0,
			'moderated'			=> 0,
			'spam'				=> 0,
			'trash'				=> 0,
			'post-trashed'		=> 0,
			'total_comments'	=> 0,
			'all'				=> 0,
		];

		foreach ($totals as $row) {
			switch ($row['comment_approved']) {
				case 'trash':
					$stats['trash']				= $row['total'];
					break;
				case 'post-trashed':
					$stats['post-trashed']		= $row['total'];
					break;
				case 'spam':
					$stats['spam']				= $row['total'];
					$stats['total_comments']	+= $row['total'];
					break;
				case '1':
					$stats['approved']			= $row['total'];
					$stats['total_comments']	+= $row['total'];
					$stats['all']				+= $row['total'];
					break;
				case '0':
					$stats['moderated']			= $row['total'];
					$stats['total_comments']	+= $row['total'];
					$stats['all']				+= $row['total'];
					break;
				default:
					break;
			}
		}

		$stats_object	= (object)$stats;
		
		wp_cache_set($cache_key, $stats_object, 'comment', MONTH_IN_SECONDS);
	}

	return $stats_object;
}, 10 ,2);