<?php
$this->header(); 
?>

<div class="d-flex" id="wrapper">


    <div class="wrapper d-flex align-items-stretch">
			
    
    <?php $this->sidebar(); ?>

    <div id="content" class="p-4 p-md-5 pt-5">
      <h2 class="mb-4">Settings</h2>
      <form class="ui form" id="settingForm">
        <?php foreach ($settings as $setting) : ?>
          <?php if ($setting->type == 'text') {?>
            <div class="ui inline fields">
              <label class="eight wide field"> <?= $setting->name ?></label>
              <input type='text' name='<?= $setting->id ?>' value='<?= $setting->value ?>'>
            </div>
          <?php } elseif ($setting->type == 'bool') { ?>
            <div class="ui inline fields">
              <label class="eight wide field"> <?= $setting->name ?></label>
              <select name='<?= $setting->id ?>'>
                <?php
                for ($i=0; $i<=1; $i++) {
                  if ($setting->value == $i) {
                    echo "<option selected value='".$i."'>".$i."</option>";
                  } else {
                    echo "<option value='".$i."'>".$i."</option>";
                  }
                }
                ?>
              </select>
            </div>
          <?php } ?>
        <?php endforeach; ?>

        <button onclick="updateSettings(this); return false;" class="ui primary button">
            Save changes
        </button>
      </form>
    </div>

    
  </div>

  
<?php $this->footer(); ?>