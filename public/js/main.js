$(document).ready(() => {
	let $location = $(location).attr('pathname');
	let $nav = $('[class^="crud-"]');

	$nav.removeClass('current-page');

	$(`a[href='${$location}']`).addClass('current-page');

	/////////////////////////////////////////

	$('body').on('click', 'button', e => {
		let $btn = $(e.currentTarget);
		let $id = $btn.data('id');
		let $class = $btn.attr('class');
		let $popUp = $('.popUp-massage');

		if ($class === 'show-more-btn') {
			e.preventDefault();
			$.post({
				url: '/api/showMore/',
				data: {
					'method': 'showMore',
				},
				success: result => {
					if (!result.error) {
						$('.products').append(result.data);

						if (!result.type) {
							$btn.remove();
						}
					} else {
						$popUp
							.text(result.data)
							.fadeIn(100)
							.fadeOut(2000);
					}
				}
			});
		} else if ($class === 'add-btn') {
			e.preventDefault();
			$.post({
				url: '/api/addToCart/',
				data: {
					'id': $id,
				},
				success: result => {
					if (!result.error) {
						if (result.type === 'add') {
							$popUp
								.text('Product successfully added!')
								.fadeIn(100)
								.fadeOut(2000);
						} else if (result.type === 'update') {
							$(`.cart-item[data-id=${$id}]`).find('span').html(result.data);
							$popUp
								.text('Product quantity updated!')
								.fadeIn(100)
								.fadeOut(2000);
						}
					}
				}
			});
		} else if ($class === 'remove-btn') {
			e.preventDefault();
			$.post({
				url: '/api/update/',
				data: {
					'id': $id,
					'value': '-'
				},
				success: result => {
					if (result.data === 0) {
						$(`.cart-item[data-id=${$id}]`).remove();
						$popUp
							.text('Product removed!')
							.fadeIn(100)
							.fadeOut(2000);
					} else {
						$(`.cart-item[data-id=${$id}]`).find('span').html(result.data);
					}
				},
			});
		} else if ($class === 'order-btn') {
			e.preventDefault();
			if (!($('.cart-item').length)) {
				$popUp
					.text('No products selected!')
					.fadeIn(100)
					.fadeOut(2000);
				return;
			}
			$.post({
				url: '/api/order/',
				data: {
					'method': 'order',
				},
				success: result => {
					if (!result.error) {
						$(location).attr('href', '/order/');
					}
				},
			});
		} else if ($class === 'cancel-btn') {
			e.preventDefault();
			$.post({
				url: '/api/status/',
				data: {
					'id': $id,
					'value': 2
				},
				success: result => {
					if (!result.error) {
						const $order = $(`.orders-item[data-id=${$id}]`);
						$order.find('.order-status').html('Cancelled');
						$btn.remove();
					}
				},
			});
		} else if ($class === 'status-btn') {
			e.preventDefault();
			const $order = $(`.orders-item[data-id=${$id}]`);
			const $status = $order.find('input');
			$.post({
				url: '/api/status/',
				data: {
					'id': $id,
					'value': $status.val()
				},
				success: result => {
					if (!result.error) {
						$status.val(result.data);
						if (result.data === 4) {
							$btn.remove();
						}
						$popUp
							.text('Status successfully updated!')
							.fadeIn(100)
							.fadeOut(2000);
					}
				},
			});
		}
	});
});