
<!-- SHARED TEMPLATE BEWEEN FESTIVAL AND SAISON EVENEMENTS -->
<?php global $image; global $has_image; ?>
<?php $id = get_the_ID(); ?>
<?php $ticketing_link = get_field('ticketing_link'); ?>
<?php $practical_info = get_field('information'); ?>
<?php $dates = get_field('dates', $id, false); ?>
<?php $members = get_field('members'); ?>
<?php $tarif_plein = get_field('tarif_plein'); ?>
<?php $tarif_plein_prevente = get_field('tarif_plein_prevente'); ?>
<?php $tarif_plein_sur_place = get_field('tarif_plein_sur_place'); ?>
<?php $tarif_reduit_sur_place = get_field('tarif_reduit_sur_place'); ?>
<?php $tarifs_reduits = get_field('tarifs_reduits'); ?>
<?php $tarif_passe_partout_jcb = get_field('tarif_passe-partout_jcb'); ?>
<?php $styles = get_field('styles'); ?>
<?php $time = get_field('time'); ?>
<?php $time_door_opens = get_field('time_door_opens'); ?>
<?php $artist_name = get_field('artist_name'); ?>
<?php $description = get_field('description'); ?>
<?php $lineup = get_field('line-up'); ?>
<?php $website = get_field('website'); ?>
<?php $countries = get_field('countries'); ?>
<?php $artist_name_minor = get_field('artist_name_minor'); ?>

<?php get_template_part( 'partials/page-header' ); ?>
<!-- article -->
<article  <?php post_class(); ?>>

  <div class="container" id="main_section">
    <div class="row">
      <div class="col-sm-4 sticky">

        <br>
        <br>
        <br>
        <br>
        <br>
        <div class="black_box ">
          <h3><?php if(have_rows('dates', $id)) : ?>
            <?php echo nice_event_dates( $dates); ?>
          <?php endif; // end of if dates ?></h3>
          <hr>
          <?php if(!empty(get_field('venue_name'))) : ?>
            <?php echo get_field('venue_name'); ?>
            <?php if (!empty($members)) : ?>
              <h4>
                <a href="<?php echo $members->guid; ?>" target="salle">
                  <?php echo $members->post_title; ?>, <?php echo get_field('ville', $members->ID); ?>
                </a>
              </h4>
              <hr>
            <?php endif; // end of if members ?>
          <?php else : ?>
            <?php if (!empty($members)) : ?>
              <h4>
                <a href="<?php echo $members->guid; ?>" target="salle">
                  <?php echo $members->post_title; ?> - <?php echo get_field('ville', $members->ID); ?>
                </a>
              </h4>
              <hr>
            <?php endif; // end of if members ?>
          <?php endif; //end of if venur_name ?>

          <?php if($time OR $time_door_opens): ?>
            <p>
              <?php if($time_door_opens) : ?>
                <span class="colleft">Ouverture des portes</span><span class="colright"><?php echo $time_door_opens; ?></span>
              <?php endif; ?>
              <?php if($time) : ?>
                <span class="colleft">Début des concerts</span><span class="colright"><?php echo $time; ?></span>
              <?php endif; ?>

            </p>
            <hr>
          <?php endif; ?>

          <?php if($tarif_plein_prevente OR $tarif_plein_sur_place OR $tarif_reduit_prevente OR $tarif_reduit_sur_place OR $tarif_passe_partout_jcb): ?>

            <?php if($tarif_plein_prevente OR $tarif_plein_sur_place): ?>
              <h5>TARIFS PLEIN</h5>
              <p>
                <?php if($tarif_plein_prevente) : ?>
                  <span class="colleft">Prévente</span><span class="colright"><?php echo $tarif_plein_prevente; ?></span>
                <?php endif; ?>
                <?php if($tarif_plein_sur_place) : ?>
                  <span class="colleft">Sur place</span><span class="colright"><?php echo $tarif_plein_sur_place; ?></span>
                <?php endif; ?>
              <?php endif; ?>
            </p>

            <?php if($tarif_reduit_prevente OR $tarif_reduit_sur_place OR $tarif_passe_partout_jcb): ?>
              <h5>TARIF(S) RÉDUIT(S)</h5>
              <p>
                <?php if($tarif_reduit_prevente) : ?>
                  <span class="colleft">Prévente (tarif normal)</span><span class="colright"><?php echo $tarif_reduit_prevente; ?></span>
                <?php endif; ?>

                <?php if($tarif_reduit_sur_place) : ?>
                  <span class="colleft">Sur place (A + R)</span><span class="colright"><?php echo $tarif_reduit_sur_place; ?></span>
                <?php endif; ?>

                <?php if($tarif_passe_partout_jcb) : ?>
                  <span class="colleft">Tarif passe-partout JCB</span><span class="colright"><?php echo $tarif_passe_partout_jcb; ?></span>
                  <a target="_blank" href="https://etickets.infomaniak.com/shop/Da2TCvSh9o/"> Acheter le passe-partout</a>
                <?php endif; ?>
              </p>
            <?php endif; ?>
            <hr>

          <?php endif; ?>

          <?php if($ticketing_link) : ?>
              <h4><span class="colleft">Billetterie en ligne</span><span class="colright"><a href="<?php echo $ticketing_link; ?>" target="_blank" style="text-decoration:underline">ici</a></span></h4>
              <hr>

          <?php endif; ?>

          <?php $latlng = get_field('venue_gmap'); ?>
          <?php if($latlng) :

            $locations = [];
            $latlngx = explode( ',', $latlng   );
            $obj = new stdClass();
            $obj->title = get_field('venue_name');
            $obj->id = '';
            $obj->url = '';
            $obj->blah = $latlng;
            $classes = 'small_map';


            if(is_array($latlngx) && sizeof($latlngx)==2){
              $obj->lat = $latlngx[0];
              $obj->lng = $latlngx[1];

            }
            array_push(  $locations,  $obj);
            echo '  <div id="map_section" class="single_evnt_map">
            <script> var $member_locations = ' . json_encode($locations) .' </script>
            <div class=" ' .  $classes .'" id="member_map_container"></div>
            </div>';

            ?>

          <?php elseif ($members && $artist_name_minor ) :  ?>
            <div id="map_section" class="single_evnt_map">
              <?php echo do_shortcode('[jazz_membres_map]'); ?>
            </div>
          <?php endif; // end of if members ?>

        </div>

      </div>
      <div class="col-sm-8">
        <div class="white_box">
          <h1>
            <?php if($artist_name): ?>
              <?php echo $artist_name; ?>
            <?php else: ?>
              <?php the_title(); ?>
            <?php endif; ?>
          </h1>
          <div class="infobar">
            <span class="place"><?php echo $countries; ?></span>
            <span class="styles">
              <?php $i =1; foreach( $styles as $style ):
                if ($i >1)  {  echo ' - '; }
                echo $style;
                $i++;
              endforeach; ?>
            </span>
          </div>
          <?php echo $description; ?>
          <h5>Line-up</h5><?php echo $lineup; ?>

          <?php if( $website): ?>
            <div class="website">
              <p>
                <a class="event_website" href="<?php echo get_field('website'); ?>" target="_blank" >
                  <i class="fa fa-link" aria-hidden="true"></i>
                  <?php echo $website; ?>
                </a>
              </p>
            </div>
          <?php endif; // end of website ?>

          <?php if(get_field('image')): ?>
            <?php $image = get_field('image')['url']; ?>
            <div class="event_featured_image">
              <img src="<?php echo $image; ?>" alt="">
              <?php $thumb_copyright= get_post(get_post_thumbnail_id())->post_content; ?>
              <?php if ( $thumb_copyright != '') : ?>
                <p class="copyright_info"><?php echo $thumb_copyright; ?></p>
              <?php endif; ?>
            </div>
          <?php elseif ($has_image): ?>
              <img src="<?php echo $image; ?>" alt="">
              <?php $thumb_copyright= get_post(get_post_thumbnail_id())->post_content; ?>
              <?php if ( $thumb_copyright != '') : ?>
                <p class="copyright_info"><?php echo $thumb_copyright; ?></p>
              <?php endif; ?>
          <?php endif; // end of if hasimage; ?>


                    <?php if($artist_name_minor): ?>
                      <?php $countries_minor = get_field('countries_minor'); ?>
                      <?php $line_up_minor = get_field('line-up_minor'); ?>
                      <?php $website_minor = get_field('website_minor'); ?>
                      <?php $description_minor = get_field('description_minor'); ?>
                      <?php $minor_photo = get_field('photo_minor'); ?>

                          <h2> <?php echo $artist_name_minor; ?></h2>
                          <div class="infobar">
                            <span class="place"><?php echo $countries_minor; ?></span>
                            <span class="styles">
                              <?php $i =1; foreach( $styles as $style ):
                                if ($i >1)  {  echo ' - '; }
                                echo $style;
                                $i++;
                              endforeach; ?>
                            </span>
                          </div>

                            <?php echo $description_minor ;?>
                            <?php if($line_up_minor) : ?>
                                <h5>Line-up: </h5>
                                <?php echo $line_up_minor;?>
                            <?php endif; // end if linupminor ?>
                            <?php if($website_minor): ?>
                              <div class="website">
                                <p>
                                  <a class="event_website" href="<?php echo $website_minor; ?>" target="_blank" >
                                    <i class="fa fa-link" aria-hidden="true"></i>
                                    <?php echo $website_minor;?>
                                  </a>
                                </p>
                              </div>
                            <?php endif; // end if websiteminor ?>

                          <?php if ($minor_photo): ?>
                              <img src="<?php echo $minor_photo['url']; ?>">
                              <?php if ($minor_photo['description'] != '') : ?>
                                <p class="copyright_info">
                                  <?php echo $minor_photo['description']; ?>
                                </p>
                              <?php endif; ?>
                          <?php endif; // end of if $minor_photo; ?>

                      <?php endif; // end if $artist_name_minor ?>




        </div>
      </div>
    </div>
  </div>

    </article>
