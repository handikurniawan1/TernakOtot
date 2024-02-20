<?php

function component($gymname, $gymprice, $gymimg, $gymstar, $gymcat, $gymid){
    $start=1;
    $star_rating = '';
    while ($start <= 5) {
        if ($gymstar < $start) {
            $star_rating .= '<i class="far fa-star"></i>';
        } else {
            $star_rating .= '<i class="fas fa-star"></i>';
        }
        $start++;
    }
    $format_price = number_format($gymprice, 0, ',', '.');

    $element = "
        <div class=\"pro\">
        <form action=\"\" method=\"post\">
                <a href=\"detailproduct.php?gym_id=$gymid\" style=\"text-decoration: none;\"> <!-- Menghilangkan dekorasi garis bawah -->
                    <img src=\"$gymimg\" alt=\"\">
                    <div class=\"des\">
                        <span>$gymcat</span>
                        <h5 style=\"color: black;\">$gymname</h5> <!-- Mengubah warna teks menjadi hitam -->
                        <div class=\"star\">
                            <h6>$star_rating</h6>
                        </div>
                        <h4>Rp. $format_price</h4>
                    </div>
                </a>
                <input type='hidden' name='gym_id' value=\"$gymid\">
            </form>
            <form action=\"\" method=\"post\">
                <button type=\"submit\" name=\"add\" class=\"fa-solid fa-cart-shopping cart\"></button>
                <input type='hidden' name='gym_id' value=\"$gymid\">
                <input type='hidden' name='price' value=\"$gymprice\">
            </form>
        </div>";
    echo $element;
}

function detailproduk($gymimg, $gymname, $gymprice, $gymtag, $gymday, $gymhour, $gymloc, $gymdesc, $gymid) {
    $format_price = number_format($gymprice, 0, ',', '.');
    $element = "
    <div id=\"product\">
        <div class=\"product_images\">
            <img src=\"$gymimg\" alt=\"Gym Image\">
        </div>
        <div class=\"product_details\">
            <h2>$gymname</h2>
            <br>
            <h3>$format_price</h3>
            <div class=\"about\">
                <p><i class=\"fa fa-calendar\" style=\"font-size:12px\"></i><span>$gymday</span></p>
                <p><i class=\"fa fa-clock-o\" style=\"font-size:12px\"></i><span>$gymhour</span></p>
                <p><i class=\"fas fa-map-marker-alt fa-xs marker\" aria-hidden=\"true\"></i><span>$gymloc</span></p>
                <p>#<span>$gymtag</span> </p>
            </div>
            <p>$gymdesc</p>
            <ul>
                <div id=\"quantity-container\" class=\"quantity-container\">
                    <label for=\"quantity\" class=\"quantity-label\">Quantity:</label>
                    <button class=\"quantity-button minus\">-</button>
                    <span id=\"quantity-value\" class=\"quantity-value\">1</span>
                    <button class=\"quantity-button plus\">+</button>
                </div>
                <br>
                <label for=\"plan\" class=\"plan-label\">Your Plan:</label>
                <br>
                <br>
                <div class=\"btn-group\" style=\"width:100%\">
                    <button id=\"plan1\" value=\"1\" style=\"width:25%\" class=\"active\">1 bulan</button>
                    <button id=\"plan2\" value=\"3\" style=\"width:25%\">3 bulan</button>
                    <button id=\"plan3\" value=\"6\" style=\"width:25%\">6 bulan</button>
                    <button id=\"plan4\" value=\"12\" style=\"width:25%\">12 bulan</button>
                </div>
            </ul>
            <br>
            <div class=\"cta\">
                <form action=\"\" method=\"POST\">
                    <input type='hidden' name='gym_id' value=\"$gymid\">
                    <input type='hidden' name='price' value=\"$gymprice\">
                    <input type=\"hidden\" name=\"selected_quantity\" id=\"selected-quantity\">
                    <input type=\"hidden\" name=\"selected_plan\" id=\"selected-plan\">
                    <button class=\"btn btn_primary\" type=\"submit\" name=\"add\">Add to Cart</button>
                </form>
            </div>
            <br>
        </div>
    </div>
    ";
    echo $element;
}

function cartElement($gymname, $gymprice, $gymimg, $gymid, $month, $qty, $total){
    $format_price = number_format($gymprice, 0, ',', '.');
    $format_total = number_format($total, 0, ',', '.');
    $element = "
    <form action=\"cart.php?action=remove&id=$gymid\" method=\"post\" class=\"cart-items\">
    <input type='hidden' name='gym_id' value=\"$gymid\">
    <tr>
        <td><button type=\"submit\" class=\"far fa-times-circle circle\" name=\"remove\"></button></td>
        <td><img src=\"$gymimg\" alt=\"\"></td>
        <td>$gymname</td>
        <td>Rp $format_price</td>
        <td>$qty</td>
        <td>$month</td>
        <td class=\"harga\">Rp $format_total</td>
    </tr>
    </form>
    ";
    echo  $element;
}

function Transaski($gymid, $kd, $gymname, $gymprice, $gymimg, $start, $end, $stat, $total){
    $format_price = number_format($gymprice, 0, ',', '.');
    $format_total = number_format($total, 0, ',', '.');

    // Kondisional untuk tombol Freeze
    $freezeButton = '';
    if ($stat == 'REQ' OR $stat == 'Freeze') {
        $freezeButton = '<button class="freeze-button disabled" disabled>Freeze</button>';
    }elseif ($stat == 'Unpaid') {
        $freezeButton = '';
    }
    else {
        $freezeButton = '<button name="freeze" class="freeze-button">Freeze</button>';
    }

    $element = '
    <form action="" method="post">
    <input type="hidden" name="id" value="' . $gymid . '">
    <input type="hidden" name="kd" value="' . $kd . '">
    <tr>
        <td><img src="' . $gymimg . '" alt=""></td>
        <td>' . $gymname . '</td>
        <td>Rp ' . $format_price . '</td>
        <td>' . $start . '/' . $end . '</td>
        <td>' . $stat . '</td>
        <td>Rp ' . $format_total . '</td>
        <td class="freeze">' . $freezeButton . '</td>
    </tr>
    </form>
    ';

    echo  $element;
}

function history($id, $start, $stat, $total){
    $format_price = number_format($total, 0, ',', '.');
    $element = "
    <form action=\"transaksi.php\" method=\"post\">
    <input type='hidden' name='kd' value=\"$id\">
    <tr>
        <td>$id</td>
        <td>$start</td>
        <td>$stat</td>
        <td>Rp $format_price</td>
        <td class=\"detail\"><button name=\"detail\" class=\"detail-button\">Detail</button></td>
    </tr>
    </form>
    ";
    echo  $element;
}
?>