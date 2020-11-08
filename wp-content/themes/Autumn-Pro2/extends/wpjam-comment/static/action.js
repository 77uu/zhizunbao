jQuery(function($){
	$('body').on('click', '.comment-digg', function(){
		var _this	= $(this);
		var args	= {
			action:		'comment_digg',
			digg_type:	$(this).hasClass('is-digged') ? 'undigg' : 'digg',
			comment_id:	$(this).data('comment_id')
		};

		$.post(ajaxurl, args, function(response, status) {
			if(response.errcode != 0){
				alert(response.errmsg);
			}else{
				_this.toggleClass('is-undigged').toggleClass('is-digged').find('span.comment-digg-count').html(response.digg_count);
			}
		});

		return false;
	});

	$('body').on('click', '.post-action', function(){
		var _this	= $(this);
		var args	= {
			action:			'post_action',
			action_type:	$(this).data('action_type'),
			post_id:		$(this).data('post_id')
		};

		$.post(ajaxurl, args, function(response, status) {
			if(response.errcode != 0){
				alert(response.errmsg);
			}else{
				if(_this.hasClass('post-like')){
					_this.toggleClass('is-unliked').toggleClass('is-liked');
				}else if(_this.hasClass('post-fav')){
					_this.toggleClass('is-unfaved').toggleClass('is-faved');
					_this.find('span.dashicons').toggleClass('dashicons-star-empty').toggleClass('dashicons-star-filled');
				}

				_this.find('span.post-action-count').html(response.action_count);

				if(_this.data('action_type').indexOf('un') == -1){
					_this.data('action_type', 'un'+_this.data('action_type'));
				}else{
					_this.data('action_type', _this.data('action_type').replace('un', ''));
				}
			}
		});

		return false;
	});
});