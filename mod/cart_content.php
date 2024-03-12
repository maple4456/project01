<?php
//建立購物車資料查詢
$SQLstring = "SELECT * FROM cart,product,product_img WHERE ip='" . $_SERVER['REMOTE_ADDR'] . "' AND orderid IS NULL AND cart.p_id=product_img.p_id AND cart.p_id=product.p_id AND product_img.sort=1 ORDER BY cartid DESC";
$cart_rs = $link->query($SQLstring);
$ptotal = 0; //設定累加的變數，初始=0
?>
<h3>鸚仔鋪：購物車</h3>
<?php if ($cart_rs->rowCount() != 0) { ?>
    <button type="button" id="btn02" name="btn02" class="btn btn-parrot2" onclick="window.history.go(-1)">回到上一頁</button>
    <a href="product.php" id="btn01" name="btn01" class="btn btn-parrot">繼續購物</a>
    <button type="button" id="btn03" name="btn03" class="btn btn-parrot2" onclick="btn_confirmLink('確定清空購物車?','./mod/shopcart_del.php?mode=2');">清空購物車</button>
    <a href="checkout.php" class="btn btn-parrot">前往結帳</a>
    <div class="table-responsive-md">
        <table class="table table-hover mt-3">
            <thead>
                <tr class="table-warning table-parrot">
                    <td width="10%">產品編號</td>
                    <td width="10%">圖片</td>
                    <td width="25%">名稱</td>
                    <td width="15%">價格</td>
                    <td width="10%">數量</td>
                    <td width="15%">小計</td>
                    <td width="15%">下次再買</td>
                </tr>
            </thead>
            <tbody>
                <?php while ($cart_data = $cart_rs->fetch()) { ?>
                    <tr>
                        <td><?php echo $cart_data['p_id']; ?></td>
                        <td><a href="goods.php?p_id=<?php echo $cart_data['p_id']; ?>" title="查看商品資訊"><img src="product_img/<?php echo $cart_data['img_file']; ?>" alt="<?php echo $cart_data['p_name']; ?>" class="img-fluid"></a></td>
                        <td><?php echo $cart_data['p_name']; ?></td>
                        <td>
                            <h5 class="color_58641d pt-1">$<?php echo $cart_data['p_price']; ?></h5>
                        </td>
                        <td style="min-width:100px;">
                            <div class="input-group">
                                <input type="number" class="form-control" id="qty[]" name="qty[]" value="<?php echo $cart_data['qty']; ?>" min="1" max="49" cartid="<?php echo $cart_data['cartid']; ?>" required style="min-width:60px;">
                            </div>
                        </td>
                        <td>
                            <h5 class="color_58641d pt-1">$<?php echo $cart_data['p_price'] * $cart_data['qty']; ?></h5>
                        </td>
                        <td>
                            <button type="button" id="btn[]" name="btn[]" class="btn btn-danger" onclick="btn_confirmLink('確定刪除本資料?','./mod/shopcart_del.php?mode=1&cartid=<?php echo $cart_data['cartid']; ?>');">取消</button>
                        </td>
                    </tr>
                <?php $ptotal += $cart_data['p_price'] * $cart_data['qty'];
                } ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="7">累計：<?php echo $ptotal; ?></td>
                </tr>
                <tr>
                    <td colspan="7">運費：100</td>
                </tr>
                <tr>
                    <td colspan="7" class="color_red">總計：<?php echo $ptotal + 100; ?></td>
                </tr>
            </tfoot>
        </table>
    </div>
<?php } else { ?>
    <div class="alert alert-warning" role="alert">抱歉！目前購物車沒有相關產品。</div>
<?php } ?>