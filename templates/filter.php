<div class="col-lg-3 col-md-3 col-sm-4 col-md-pull-9">
    <aside class="aa-sidebar">
        <?php
        if (!$hideFilterFirm) {
        ?>
        <div class="aa-sidebar-widget">
            <h3>Бренд</h3>
            <select multiple="multiple" class="SlectBox" placeholder="Все бренды">
                <?php
                foreach ($this->registry['firms'] as $id=>$firmit) {
                    echo '<option id="firm_'.$id.'"/> ' . $firmit->name . '</option>';
                }
                ?>
            </select>
        </div>
        <?php
        }
        if (!$hideFilterType) {
        ?>
        <div class="aa-sidebar-widget">
            <h3>Для кого</h3>
            <select multiple="multiple" class="SlectBox" placeholder="Для всех">
                <?php
                foreach ($this->registry['types'] as $id=>$type) {
                    echo '<option id="type_'.$id.'"/> ' . $type . '</option>';
                }
                ?>
            </select>
        </div>
        <?php
        }
        if (!$hideFilterCat) {
        ?>
        <div class="aa-sidebar-widget">
            <h3>Что</h3>
            <select multiple="multiple" class="SlectBox" placeholder="Все товары">
                <?php
                foreach ($this->registry['supercats'] as $id=>$supercat) {
                    echo '<option id="supercat_'.$id.'"/> ' . $supercat . '</option>';
                }
                ?>
            </select>
        </div>
        <?php
        }
        ?>
        <div class="aa-sidebar-widget">
            <h3>От чего</h3>
            <select multiple="multiple" class="SlectBox" placeholder="От любой проблемы">
                <?php
                foreach ($this->registry['problems'] as $id=>$problem) {
                    echo '<option id="problem_'.$id.'"/> ' . $problem . '</option>';
                }
                ?>
            </select>
        </div>
        <div class="aa-sidebar-widget">
            <h3>Для чего</h3>
            <select multiple="multiple" class="SlectBox" placeholder="Любой эффект">
                <?php
                foreach ($this->registry['effects'] as $id=>$effect) {
                    echo '<option id="effect_'.$id.'"/> ' . $effect . '</option>';
                }
                ?>
            </select>
        </div>
        <div class="aa-sidebar-widget">
            <h3>По типу кожи</h3>
            <select multiple="multiple" class="SlectBox" placeholder="Все типы">
                <?php
                foreach ($this->registry['skintypes'] as $id=>$skintype) {
                    echo '<option id="skintype_'.$id.'"/> ' . $skintype . '</option>';
                }
                ?>
            </select>
        </div>
        <div class="aa-sidebar-widget">
            <h3>По типу волос</h3>
            <select multiple="multiple" class="SlectBox" placeholder="Все типы">
                <?php
                foreach ($this->registry['hairtypes'] as $id=>$hairtype) {
                    echo '<option id="hairtype_'.$id.'"/> ' . $hairtype . '</option>';
                }
                ?>
            </select>
        </div>
    </aside>
</div>
