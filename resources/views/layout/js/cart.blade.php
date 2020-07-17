<script type="text/javascript">

    function formatNumber(num) {
        return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.")
    }

    var cart_produk = {!! $cart_produk !!}
    var cart_total = {{ $cart_total }}

    function delete_cart(delete_cart) {
        key = $('.delete_cart').index($(delete_cart))

        alert(cart_produk[key].NamaProduk)
        $.ajax({
            type: "GET",
            url: "{{ url('/shop/delete-cart') }}/" + cart_produk[key].IdCart,
            success: function (msg) {

                cart_total -= cart_produk[key].sub_total
                cart_produk.splice(key, 1)

                $('#cart_total').html('Rp' + formatNumber(cart_total))
                $('#cart_count').html(cart_produk.length)
                $('#cart_content li').eq(key).remove()

                alert('sukses menghapus item dari cart')
            }
        });
    }

    function addToCart() {
        alert($('#IdProduk').val() + " " + $('#IdWarna').val() + " " + $('#IdUkuran').val() + " " + $('#Qty').val())

        data = {
            "_token": "{{ csrf_token() }}",
            'IdProduk': $('#IdProduk').val(),
            'IdWarna': $('#IdWarna').val(),
            'IdUkuran': $('#IdUkuran').val(),
            'Qty': $('#Qty').val(),
        }

        $.ajax({
            type: "POST",
            url: "{{ url('/shop/add-cart') }}/",
            data: data,
            success: function (data) {
                var new_item = true
                var sub_total = data.sub_total
                var key = -1;

                cart_produk.forEach(function (produk, index) {
                    if (produk.IdCart == data.IdCart) {
                        new_item = false
                        sub_total -= produk.sub_total
                        cart_produk[index] = data
                        key = index
                    }
                })

                if (new_item) {
                    cart_produk.push(data)
                }

                cart_count = cart_produk.length
                cart_total += sub_total

                content = `
                <li class="single-shopping-cart">
                    <div class="shopping-cart-img">
                        <a href="#"><img alt="" width="82px" height="82px" src="img/produk/`+ data.GambarProduk + `"></a>
                    </div>
                    <div class="shopping-cart-title">
                        <h4><a href="#">`+ data.NamaProduk + `(` + data.NamaWarna + `/` + data.NamaUkuran + `)</a></h4>
                        <h6 class='qty'>Qty: `+ data.Qty + `</h6>
                        <span class='sub_total'>Rp`+ formatNumber(data.sub_total) + `</span>
                    </div>
                    <div class="shopping-cart-delete">
                        <a href="#" class='delete_cart' onclick="delete_cart(this)"><i class="fa fa-times-circle"></i></a>
                    </div>
                </li>
                `

                $('#cart_total').html('Rp' + formatNumber(cart_total))
                $('#cart_count').html(cart_count)

                if (new_item) {
                    alert('new item')
                    $('#cart_content').append(content)
                } else {
                    $('#cart_content .qty').eq(key).html('Qty: ' + data.Qty)
                    $('#cart_content .sub_total').eq(key).html('Rp: ' + formatNumber(data.sub_total))
                }
                alert('sukses menambah item ke cart')
            }
        });
    }
</script>