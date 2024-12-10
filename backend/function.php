<?php
function inSanPham($img,$fullname,$brand,$price,$discount,$status){
    echo "<div class=\"col\">";
        echo "<div class=\"card\" style=\"width: 19rem;\">";
            echo "<img class=\"card-img-top\" src=\"image/".$img."\">";
            echo "<div class=\"card-body\">";
                echo "<p class=\"card-text brand\">".$brand."</p>";
                echo "<h5 class=\"card-title mb-1\">".$fullname."</h5>";
                echo "<p class=\"card-text giathanh\">".$price."<span>".$discount."</span></p>";
                echo "<p class=\"card-text tinhtrangsp\">".$status."</p>";
                echo "<a href=\"#\" class=\"btn\" id=\"chitietsanpham\">Xem chi tiết</a>";
            echo "</div>";
        echo "</div>";
    echo "</div>";
}
?>
