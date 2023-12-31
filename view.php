<!-- dit bestand bevat alle code voor de pagina die één product laat zien -->
<?php
include __DIR__ . "/components/header.php";


$StockItem = getStockItem($_GET['id'], $databaseConnection);
$StockItemImage = getStockItemImage($_GET['id'], $databaseConnection);
if (isset($_POST["submit-add-to-card"])) {              // zelfafhandelend formulier
    $stockItemID = $_POST["stockItemID"];
    addProductToCart("$stockItemID");         // maak gebruik van geïmporteerde functie uit cartfuncties.php
}
?>

<div id="CenteredContent">
    <?php
    if ($StockItem != null) {
    ?>
        <?php
        if (isset($StockItem['Video'])) {
        ?>
            <div id="VideoFrame">
                <?php print $StockItem['Video']; ?>
            </div>
        <?php }
        ?>

        <div id="ArticleHeader">
            <?php
            if (isset($StockItemImage)) {
                // één plaatje laten zien
                if (count($StockItemImage) == 1) {
            ?>
                    <div id="ImageFrame" style="background-image: url('Pub/StockItemIMG/<?php print $StockItemImage[0]['ImagePath']; ?>'); background-size: 300px; background-repeat: no-repeat; background-position: center;"></div>
                <?php
                } else if (count($StockItemImage) >= 2) { ?>
                    <!-- meerdere plaatjes laten zien -->
                    <div id="ImageFrame">
                        <div id="ImageCarousel" class="carousel slide" data-interval="false">
                            <!-- Indicators -->
                            <ul class="carousel-indicators">
                                <?php for ($i = 0; $i < count($StockItemImage); $i++) {
                                ?>
                                    <li data-target="#ImageCarousel" data-slide-to="<?php print $i ?>" <?php print(($i == 0) ? 'class="active"' : ''); ?>></li>
                                <?php
                                } ?>
                            </ul>

                            <!-- slideshow -->
                            <div class="carousel-inner">
                                <?php for ($i = 0; $i < count($StockItemImage); $i++) {
                                ?>
                                    <div class="carousel-item <?php print ($i == 0) ? 'active' : ''; ?>">
                                        <img src="Pub/StockItemIMG/<?php print $StockItemImage[$i]['ImagePath'] ?>">
                                    </div>
                                <?php } ?>
                            </div>

                            <!-- knoppen 'vorige' en 'volgende' -->
                            <a class="carousel-control-prev" href="#ImageCarousel" data-slide="prev">
                                <span class="carousel-control-prev-icon"></span>
                            </a>
                            <a class="carousel-control-next" href="#ImageCarousel" data-slide="next">
                                <span class="carousel-control-next-icon"></span>
                            </a>
                        </div>
                    </div>
                <?php
                }
            } else {
                ?>
                <div id="ImageFrame" style="background-image: url('Pub/StockGroupIMG/<?php print $StockItem['BackupImagePath']; ?>'); background-size: cover;"></div>
            <?php
            }
            ?>


            <h1 class="StockItemID">Artikelnummer: <?php print $StockItem["StockItemID"]; ?></h1>
            <h2 class="StockItemNameViewSize StockItemName">
                <?php print $StockItem['StockItemName']; ?>
            </h2>
            <div class="QuantityText">Aantal producten op vooraad: <?php echo explode(" ", $StockItem['QuantityOnHand'])[1] ?></div>
            <div id="StockItemHeaderLeft">
                <div class="CenterPriceLeft">
                    <div class="CenterPriceLeftChild">
                        <p class="StockItemPriceText"><b><?php print sprintf("€ %.2f", $StockItem['SellPrice']); ?></b></p>
                        <h6> Inclusief BTW </h6>
                        <form method="post">
                            <input type="number" name="stockItemID" value="<?php print($_GET['id']) ?>" hidden>
                            <button class=" mt-4" type="submit" name="submit-add-to-card" value="Voeg toe aan winkelmandje">Voeg toe aan <i class="fa fa-shopping-cart"></i></button>
                        </form>
                        <?php
                        if (isset($_POST["submit-add-to-card"]) && $_POST["stockItemID"] == $_GET['id']) { 
                            print("Product toegevoegd aan <a href='cart.php'> winkelmandje!</a>");
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>


        <div id="StockItemSpecifications">
            <h3>Artikel specificaties</h3>
            <?php
            $CustomFields = json_decode($StockItem['CustomFields'], true);
            if (is_array($CustomFields)) { ?>
                <table>
                    <thead>
                        <th>Naam</th>
                        <th>Data</th>
                    </thead>
                    <?php
                    foreach ($CustomFields as $SpecName => $SpecText) { ?>
                        <tr>
                            <td>
                                <?php print $SpecName; ?>
                            </td>
                            <td>
                                <?php
                                if (is_array($SpecText)) {
                                    foreach ($SpecText as $SubText) {
                                        print $SubText . " ";
                                    }
                                } else {
                                    print $SpecText;
                                }
                            }
                            ?>
                        </td>
                    </tr>
                <?php
                if ($StockItem['IsChillerStock'] == 1){
                ?>
                    <tr>
                        <td>
                            Tempratuur:
                        </td>
                        <td>
                            <?php
                            echo (GetChiller5($databaseConnection)."°C")
                            ?>

                        </td>
                    </tr><?php } ?>
                </table>
                
                <?php
                    } else { ?>

                <p><?php print $StockItem['CustomFields']; ?>.</p>
            <?php
                    }
            ?>
        </div>
        <div id="StockItemDescription">
            <h3>Artikel beschrijving</h3>
            <p><?php print $StockItem['SearchDetails']; ?></p>
        </div>

<?php

require_once __DIR__ . "/components/meestGekochteProducten.php";

} else {
    ?><h2 id="ProductNotFound">Het opgevraagde product is niet gevonden.</h2><?php
}
?>
</div>
<?php
include __DIR__ . "/components/footer.php";
