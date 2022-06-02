<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<style>
  .promotions_list .caroufredsel_wrapper{
    height: 353px!important;
  }

  .promotions_list .content-thumb {
    overflow: hidden;
    width: 627px!important;
    height: 353px!important;
  }

  .amount{
    font-size:18px!important;
  }
</style>

<div class="container promotions_list">
  <div class="recent-properties-inner">
    <div class="recent-properties-title">
      <h3>PROMOCIONES</h3>
    </div>
    <div class="recent-properties-content">
      <div class="caroufredsel-wrap">
        <ul>
          <?php foreach($promotions as $promotion):?>
          <li>
            <article class="hentry has-featured">
              <div class="property-featured">
                <a class="content-thumb" href="<?= base_url() ?>packages/show_package/<?= $promotion->id ?>">
                  <img src="<?= base_url().$promotion->image_path ?>" class="attachment-property-image" alt=""/> </a>
                <span class="property-category"><a href="<?= base_url() ?>packages/show_package/<?= $promotion->id ?>"><?=$promotion->name ?></a></span>
              </div>
              <div class="property-wrap">
                <h2 class="property-title"><a href="<?= base_url() ?>packages/show_package/<?= $promotion->id ?>" title="<?=$promotion->name?>"><?=$promotion->name?></a></h2>
                <div class="property-excerpt">
                  <p><?=$promotion->description?></p>
                </div>
                <div class="property-summary">                
                  <div class="property-info">
                    <div class="property-price">
                      <span><span class="amount"><?=$promotion->price ?></span> </span>
                    </div>
                    <div class="property-action">
                      <a href="<?= base_url() ?>packages/show_package/<?= $promotion->id ?>">Mas detalles <i class="fa fa-arrow-circle-o-right"></i></a>
                    </div>
                  </div>
                </div>
              </div>
            </article>
          </li>
          <?php endforeach;?>
        </ul>
      </div>
      <a class="caroufredsel-prev" href="#"></a>
      <a class="caroufredsel-next" href="#"></a>
    </div>
  </div>
</div>
