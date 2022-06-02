<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<style>
  .caroufredsel_wrapper{
    height: 292px!important;
  }

  .content-thumb {
    overflow: hidden;
    width: 359px!important;
    height: 292px!important;
  }
  .amount{
    font-size:16px!important;
  }
</style>
<div class="container noo-mainbody">
  <div class="noo-mainbody-inner">
    <div class="row clearfix">
      <div class="noo-content col-xs-12">
        <div class="recent-properties">
          <div class="properties grid">
            <div class="properties-header">
              <h1 class="page-title"><?= !isset($category_name) ? $category->name : $category_name?></h1>
            </div>
            <div class="properties-content">

              <?php foreach ($packages as $package) : ?>
                <article class="hentry">

                  <div class="property-featured">
                    <!--<span class="featured"><i class="fa fa-star"></i></span>-->
                    <a class="content-thumb" href="<?= base_url() ?>packages/show_package/<?= $package->id ?>">
                      <img src="<?= base_url() . $package->image_path ?>" alt="">
                    </a>
                    <!--<span class="property-label">Hot</span>-->
                    <span class="property-category"><a href="<?= base_url() ?>package/<?= $package->id ?>"><?= $package->name ?></a></span>
                  </div>
                  <div class="property-wrap">
                    <h2 class="property-title">
                      <a href="<?= base_url() ?>packages/show_package/<?= $package->id ?>" title="<?= $package->name ?>"><?= $package->description ?></a>
                    </h2>

                    <div class="roperty-summary">

                      <div class="property-info">
                        <div class="property-price">
                          <span>
                            <span class="amount"><?= $package->price ?></span>
                          </span>
                        </div>
                        <div class="property-action">
                          <a href="<?= base_url() ?>packages/show_package/<?= $package->id ?>">Mas Detalles</a>
                        </div>
                      </div>

                    </div>
                  </div>
                </article>

              <?php endforeach; ?>

              <div class="clearfix"></div>

<!--              <nav class="pagination-nav">
                <ul class="pagination list-center">
                  <li><a class="prev page-numbers" href="#"><i class="fa fa-angle-left"></i></a></li>
                  <li><span class="page-numbers current">1</span></li>
                  <li><a class="page-numbers" href="#">2</a></li>
                  <li><span class="page-dots"><i class="fa fa-ellipsis-h"></i></span></li>
                  <li><a class="page-numbers" href="#">7</a></li>
                  <li><a class="page-numbers" href="#">8</a></li>
                  <li><a class="next page-numbers" href="#"><i class="fa fa-angle-right"></i></a></li>
                </ul>
              </nav>-->

            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
</div>