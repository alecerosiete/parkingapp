<style>
  .align-center{
    text-align:center;
  }
  .flyer img {
    max-width: 100%;
  }
  </style>

<div class="container noo-mainbody">
  <div class="noo-mainbody-inner">
    <div class="row clearfix">

      <div class="noo-content col-xs-12">

        <div class="row noo-row accordion-shortcode clearfix">
          <div class="col-sm-12 col-md-12 noo-col">
            <div class="noo-text-block">
              <h3 class="text-primary"><?= $package->name ?> </h3>
              <p><?= $package->description ?></p>
            </div>

          </div>

        </div>
        <div class="property">
          <div class="property-summary">
            <div class="row">
              <div class="col-md-4">
                <div class="property-detail">
                  <h4 class="property-detail-title text-primary">Precio</h4>
                  <div class="property-detail-content">
                    <h4><i class="fa fa-tag"></i>&nbsp;<?= $package->price ?></h4>
                  </div>
                </div>
                <br>
              </div>
              
              <div class="col-md-4">
                <div class="property-detail">
                  <h4 class="property-detail-title text-primary">Fecha para Comprar</h4>
                  <div class="property-detail-content">
                    <h4><i class="fa fa-calendar"></i>&nbsp;<?= convert_datetime($package->valid_for_buy) ?></h4>
                  </div>
                </div>
                <br>
              </div>
              
              <div class="col-md-4">
                <div class="property-detail">
                  <h4 class="property-detail-title text-primary">Fecha para Viajar</h4>
                  <div class="property-detail-content">
                    <h4><i class="fa fa-calendar"></i>&nbsp;<?= convert_datetime($package->valid_for_travel) ?></h4>
                  </div>
                </div>
              </div>

            </div>
            <hr class="line">
            <div class="row">
              <div class="col-md-12 align-center flyer">
                <img src="<?= base_url() . $package->image_path ?>">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>

</div>