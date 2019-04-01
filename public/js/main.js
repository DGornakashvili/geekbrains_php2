$(document).ready(() => {
  let $location = $(location)[0].pathname;
  let $navBtn = $('[class^="crud-"]');
  $navBtn.removeClass('current-page');

  if ($location === '/') {
    $navBtn = $('.crud-main');
  } else if ($location === '/products/') {
    $navBtn = $('.crud-products');
  } else if ($location === '/account/') {
    $navBtn = $('.crud-account');
  } else if ($location === '/basket/') {
    $navBtn = $('.crud-cart');
  } else if ($location === '/order/') {
    $navBtn = $('.crud-orders');
  }else if ($location === '/order/getAllOrders/') {
    $navBtn = $('.crud-allOrders');
  }

  $navBtn.addClass('current-page');

  /////////////////////////////////////////

  $('body').on('click', 'button', e => {
    let $btn = e.target;
    let $container = $('.products');
    let $id = e.target.dataset.id;

    if ($btn.className === 'show-more-btn') {
      e.preventDefault();
      $.post({
        url: '/api/showMore/',
        data: {
          'method': 'showMore',
        },
        success: result => {
          if (!result.error) {
            $container.append(result.data);

            if (!result.type) {
              $btn.remove();
            }
          } else {
            alert(result.data);
            $btn.remove();
          }
        }
      });
    } else if ($btn.className === 'add-btn') {
      e.preventDefault();
      $.post({
        url: '/api/addToCart/',
        data: {
          'id': $id,
        },
        success: result => {
          if (!result.error) {
            if (result.type === 'add') {
              alert('Product successfully added!');
            } else if (result.type === 'update') {
              $(`.cart-item[data-id=${$id}]`).find('span').html(result.data);
              alert('Product successfully added!');
            }
          }
        }
      });
    } else if ($btn.className === 'remove-btn') {
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
          } else {
            $(`.cart-item[data-id=${$id}]`).find('span').html(result.data);
          }
        },
      });
    } else if ($btn.className === 'order-btn') {
      e.preventDefault();
      if (!($('.cart-item').length)) {
        alert('Cart is empty!');
        return;
      }
      $.post({
        url: '/api/order/',
        data: {
          'method': 'order',
        },
        success: result => {
          if (!result.error) {
            alert(`Order success, order ID: ${result.data}`);
            $(location).attr('href', '/order/');
          }
        },
      });
    } else if ($btn.className === 'cancel-btn') {
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
            $order.find(`.${$btn.className}`).remove();
          }
        },
      });
    } else if ($btn.className === 'status-btn') {
      e.preventDefault();
      const $order = $(`.orders-item[data-id=${$id}]`);
      const $status = $order.find('.item-status').find('input');
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
              $order.find(`.${$btn.className}`).remove();
            }
            alert('Status successfully updated!');
          }
        },
      });
    }
  });
});