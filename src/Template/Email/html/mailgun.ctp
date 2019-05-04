<head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8"></head>
<table style="width:100%;height:100%;max-width:600px;border-spacing:0;border-collapse:collapse;border:1px solid #e6e7eb;margin:0 auto" align="center">
    <tbody>
        <tr>
            <td>
                <table style="border-spacing:0;border-collapse:collapse;width:100%" width="100%" align="center">
                    <thead>
                        <tr bgcolor="#F9AE3C">
                            <th width="90%">
                                <h2 style="margin:0;padding:20px;text-align:left">
                                    <div>
                                        <img src="https://www.wowmua.com/img/mail/logo.png" alt="logo WOWMUA.png" data-image-whitelisted="" class="CToWUd" width="173" height="46"><br>
                                    </div>
                                </h2>
                            </th>
                            <th width="10%">
                                <h2 style="padding:20px;margin:0;box-sizing:border-box"></h2>
                            </th>
                        </tr>
                    </thead>
                </table>
            </td>
        </tr>
        <tr bgcolor="white">
            <td style="padding:20px 20px 10px">
                <table style="border-spacing:0;border-collapse:collapse;width:100%">
                    <tbody>
                        <tr>
                            <td>
                                <span style="font-size:17px"></span>
                                <p class="MsoNormal" style="margin:0in 0in 10pt;line-height:115%;font-size:11pt;font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;">
                                    <span style="font-size:8.5pt;line-height:115%;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;;color:rgb(89,89,89);background:white none repeat scroll 0% 0%"></span>
                                </p>

                                <p class="MsoNormal" style="margin:0in 0in 10pt;line-height:115%;font-size:11pt;font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;">
                                    <span style="font-size:10pt;line-height:115%;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;;color:rgb(89,89,89);background:white none repeat scroll 0% 0%">
                                        <?= __('Xin chào {0}', $order->user->first_name . ' ' . $order->user->last_name); ?>
                                    </span>
                                </p>

                            </td>
                        </tr>

                        <tr>
                            <td>
                                <p style="color:#636363">
                                    <span style="font-size:10pt;line-height:115%;font-family:&quot;Arial&quot;,&quot;sans-serif&quot; color:rgb(89,89,89);background:white none repeat scroll 0% 0%">
                                        <?= __('Cảm ơn bạn đã đặt hàng tại Wowmua') ?>
                                    </span>.
                                </p>

                                <p class="MsoNormal" style="margin:0in 0in 0.0001pt;line-height:normal;background:white none repeat scroll 0% 0%;font-size:11pt;font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;">
                                    <span style="font-size:10pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;;color:rgb(89,89,89);background:white none repeat scroll 0% 0%">
                                        <?= __('Đơn hàng') ?>  <b style="color:rgb(204,0,0)"><?= $order->order_code; ?>&nbsp;</b> (<?= $order->created; ?>) <?= __('của bạn đang') ?> <b style="color:rgb(204,0,0)"><?php echo $order->statuses[($order->status == 'REQUEST') ? 'UNPAID' : $order->status]; ?></b>
                                    </span>
                                </p>
                                <p></p>
                                <p class="MsoNormal" style="margin:0in 0in 0.0001pt;line-height:normal;background:white none repeat scroll 0% 0%;font-size:11pt;font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;">
                                    <span style="font-size:10pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;;color:rgb(89,89,89);background:white none repeat scroll 0% 0%">
                                        <?= __('Wowmua sẽ gửi thông báo đến bạn thông qua email khác sau khi trạng thái đơn hàng thay đổi.') ?>
                                    </span>
                                </p>
                            </td>
                        </tr>
        <tr bgcolor="white"> </tr>
        <tr bgcolor="white">
            <td style="padding:20px 20px 0 20px">
                <table style="border-spacing:0;border-collapse:collapse" width="100%" align="center">
                    <tbody>
                        <tr>
                            <td>
                                <span style="color:rgb(255,153,0)"><?= __('THÔNG TIN NHẬN HÀNG') ?></span>
                                <br/><br/>
                                &nbsp;&nbsp;
                                <a href="#" style="box-sizing:border-box;margin:0px;padding:0px;color:rgb(0,123,255);text-decoration-line:none;display:inline-block;font-family:Poppins,sans-serif" >
                                    <?= $order->user->first_name . ' ' . $order->user->last_name; ?></a>
                                - <span style="color:rgb(128,128,128);font-family:Poppins,sans-serif">&nbsp;0937475545&nbsp;</span>
                                <br/>
                                &nbsp;&nbsp;
                                <a href="" target="_blank"><?= $order->user->email; ?></a>
                                <br/><br/>
                                &nbsp;
                                <span style="color:rgb(128,128,128);font-family:Poppins,sans-serif;background-color:rgb(242,242,242)">
                                    <?= $order->user->address; ?></span>
                                <br />
                            </td>
                        </tr>
                        <tr><td>&nbsp;</td></tr>
                        <tr>
                            <td style="border-bottom:1px solid #e6e7eb">
                                <span style="text-transform:uppercase; color:rgb(255,153,0)"><?= __('Thời gian nhận hàng dự kiến') ?></span>
                                <br/>
                                <p>
                                    <?= __('Trong vòng 14 ngày kể từ khi hoàn tất thanh toán đơn hàng') ?>&nbsp;
                                </p>
                                <span style="color:rgb(170,170,170);font-size:11px;text-transform:uppercase;display:block;padding-bottom:7px"><?= __('CHI TIẾT ĐƠN HÀNG') ?></span>
                                <p>
                                    <span><i class="zmdi zmdi-flight-takeoff"></i> <?= $order->from_location; ?></span>
                                    &nbsp;&nbsp;&nbsp;
                                    <span><i class="zmdi zmdi-flight-land"></i> <?= $order->to_location; ?></span>
                                    <table>
                                    <?php foreach ($order->purchases as $purchase): ?>
                                        <tr>
                                        <td>
                                        <?php $product = $this->Common->getProductInfoByProductId($purchase->product_id); ?>
                                        <?php $thumb = @getimagesize($product['thumb']) ? $product['thumb'] : 'https://via.placeholder.com/200x200?text=wowmua.com'; ?>
                                        <img id="myImg" class="align-self-start mr-3 img-thumbnail" src="<?php echo $product['thumb'] ?>" alt="" width="200px">
                                        </td>
                                        <td>
                                        <div class="media-body" style="margin-top: 2px;">
                                            <p><?= __('Giá SP') ?> : <span class="status--process"><?php echo number_format($purchase->price); ?> <?php echo $this->Common->getCurrency($order->from_location); ?></span>
                                                <span class="status--process"> (<?= __('SL') ?>: <i class="zmdi zmdi-plus"></i><?php echo $purchase->quantity; ?>)</span>
                                                <br>
                                                <?= __('Phí ship nội địa') ?>: <span class="status--process"><?php echo $product['local_ship']; ?> </span>
                                                <br>
                                                <?= __('Trọng lượng') ?>: <span class="status--process"><?php echo $product['weight']; ?> </span>
                                                <br>
                                                <?= __('Ghi chú') ?>: <span class="status--process"><?php echo $product['note']; ?> </span>
                                                <br>
                                                <?= __('Giá') ?> (<sup>vnđ</sup>): <span class="status--process"><?php echo number_format(round($product['calc_price'])); ?> <sup>đ</sup> </span>
                                            </p>
                                        </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </table>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        <tr><td>&nbsp;</td></tr>
        <tr>
            <td>
                &nbsp;&nbsp;<?= __('Một lần nữa Wowmua cảm ơn bạn.') ?>
            </td>
        </tr>
        <tr><td>&nbsp;</td></tr>
        <tr>
            <td>
                <table style="border-spacing:0px;border-collapse:collapse" width="100%" align="center">
                    <tbody>
                        <tr style="border-top:1px solid rgb(230,231,235)">
                            <td style="padding:15px 0px;text-align:left">
                                <?= __('Bạn cần được hỗ trợ ngay?') ?><br/>
                                Hotline: 0934.007.012 <br/>
                                Email: wowmua.info@gmail.com<br/>
                                Fanpage: <a href="https://www.facebook.com/WowMua.global/" style="color:blue;text-decoration:underline" target="_blank" data-saferedirecturl="https://www.google.com/url?q=https://www.facebook.com/WowMua.global/&amp;source=gmail&amp;ust=1542333457135000&amp;usg=AFQjCNHEvVNVxhqNor4eInGRT39ZUw5Hiw">WowMua</a><br/>
                                (8:00-20:00 <?= __('bao gồm thứ bảy, chủ nhật') ?>)
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table>
</td>
</tr>
</tbody>
</table>
