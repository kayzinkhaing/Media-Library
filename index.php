<?php 
include("inc/data.php");
include("inc/function.php");

$pageTitle= "Personal Media Library";
$section=null;
    
include("inc/header.php"); ?>
    <div class="section">
        <div class="wrapper">
            <h2>May we suggest something?</h2>
            
            <ul class="items">
                <?php 
                    $random = array_rand($catalog,4);
                    foreach ($random as $id) {
                        echo get_item_html($id,$catalog[$id]);
                    }
                ?>
            </ul>
        </div>
    
    </div>

</div> 

<?php include("inc/footer.php"); ?>
</body>
</html>
    