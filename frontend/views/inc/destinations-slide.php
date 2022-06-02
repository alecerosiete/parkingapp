<style>
  .packages_list .caroufredsel_wrapper{
    height: 231px!important;
  }

  .font-size-12{
      font-size: 12px!important;
  }
  .packages_list .content-thumb {
    overflow: hidden;
    width: 100%!important;
    height: 231px!important;
  }
</style>
<div class="container packages_list">
  <?php
  $i = 0;
  foreach ($slides as $slide):
    if (empty($packages[$slide->id])) {
      continue;
    }
    ?>
    <!--destinations list CARIBE-->
    <div class="recent-properties-inner ">
      <div class="section-title">
        <h2><?= $slide->name ?></h2>
      </div>
      <div class="recent-properties-content">
        <div class="caroufredsel-wrap">
          <ul>
            <?php foreach ($packages[$slide->id] as $package) : ?>
              <?php if ($i == 0) : ?>
                <!--packages list-->
                <li>
                  <div class="property-row">
                  <?php endif; ?>
                  <?php $i++; ?>
                  <article class="hentry has-featured">
                    <div class="property-featured">
                      <a class="content-thumb" href="<?= base_url() ?>packages/show_package/<?= $package->id ?>">
                        <img src="<?= base_url() . $package->image_path ?>" class="attachment-property-thumb" alt=""/> </a>
                      <span class="property-category"><a href="#"><?= $package->name ?></a></span>
                      <div class="property-detail">
                        <div><span class="fa fa-calendar"></span>
                          Salida: <?= convert_datetime($package->valid_for_travel) ?>
                        </div>
                      </div>
                    </div>
                    <div class="property-wrap">
                      <h2 class="property-title"><a href="<?= base_url() ?>packages/show_package/<?= $package->id ?>" title="<?= $package->name ?>"><?= $package->name ?></a></h2>
                      <div class="property-excerpt">
                        <p><?= $package->description ?></p>
                      </div>
                    </div>
                    <div class="property-summary">
                      <div class="property-info">
                        <div class="property-price">
                          <span><span class="amount font-size-12"><?= $package->price ?></span></span>
                        </div>
                        <div class="property-action">
                          <a class="font-size-12" href="<?= base_url() ?>packages/show_package/<?= $package->id ?>">M&aacute;s Detalles</a>
                        </div>
                      </div>
                    </div>
                  </article>
                  <?php if ($i == 2) : $i = 0; ?>
                  </div>
                </li>
              <?php endif; ?>
              <!--end packages list-->
            <?php endforeach; ?>
          </ul>
        </div>
        <a class="caroufredsel-prev" href="#"></a>
        <a class="caroufredsel-next" href="#"></a>
      </div>
    </div>

    <!--end destinations list-->

    <P>-</P>
    <?php
    $i = 0;
  endforeach;
  ?>

</div>


