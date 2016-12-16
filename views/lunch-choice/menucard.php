<div style="flex-grow:1;flex-basis: 0;margin:10px;border: 2px solid #ccc;box-shadow: 0 5px 10px rgba(0,0,0,.2);" data-user-selected="<?= $userSelected ? 1 : 0 ?>"
     class="menucard panel   text-center"
     data-menu-date="<?= $menu->date ?>" >

    <h2>
        <?php if ($userSelected) { ?>
            <i class="glyphicon glyphicon-ok" style="color:deepskyblue"></i>
        <?php } ?>
        <strong><?= $menu->letter ?></strong>
    </h2>

    <?php if (!$userSelected && date('Y-m-d')<=$lastWednesday) { ?>
        <button class="btn btn-primary" style="margin-bottom: 10px" data-menu-id="<?= $menu->id ?>">Ezt választom!</button>
    <?php } ?>
    <?php if ($userSelected) { ?>
        <img  src="/images/eating.png" alt=""
              style="width:40px;margin-bottom: 10px">
    <?php } ?>


    <ul class="text-left" style="list-style-type: none;padding-left: 15px;padding-right: 10px;font-size: medium">
        <?php
        $description = "";
        foreach ($menu->foodsSorted as $food) {
            ?>
            <li class="food" style="margin-bottom:5px;display: flex;cursor:pointer;"
                data-food-id="<?=$food->id?>"
                data-food-name="<?=$food->name?>"
                data-food-desc="<?=$food->description?>"
                data-food-image="<?=$food->image?>"
            >

                <img  src="/images/<?=$food->category?>.png" alt=""
                     class=""
                style="height:20px;flex-basis: 40px">
                <span style="flex-grow: 1;margin-left:5px"><?= $food->translate(Yii::$app->language)->name ?></span></li>
        <?php } ?>
    </ul>

</div>