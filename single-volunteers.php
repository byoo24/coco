<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package coco
 */


 //https://code.tutsplus.com/tutorials/how-to-create-custom-wordpress-writemeta-boxes--wp-20336
 //https://code.tutsplus.com/articles/reusable-custom-meta-boxes-part-1-intro-and-basic-fields--wp-23259
 //https://code.tutsplus.com/articles/reusable-custom-meta-boxes-part-2-advanced-fields--wp-23293


 include_once('inc/volunteer-meta.php');

get_header(); ?>



  <div class="volunteer-header">
    <h1 class="volunteer-title"><?php _e('Volunteer Application', 'coco')?></h1>

    <ul id="top_nav">
      <li><a position="0" class="active">Application</a></li>
      <li><a position="1">Emergency Card</a></li>
      <li><a position="2">Term of Service</a></li>
    </ul>
  </div>


	<div id="primary" class="content-area">
		<main id="main" class="site-main page-container" role="main">

			<form action="" id="volunteer_form" method="POST">

        <?php
          echo '<div id="app_info" class="app_form active">';
            show_meta_box($contact_fields);
            show_meta_box($availability_fields);
            show_meta_box($reason_fields);
            show_meta_box($previous_fields);
          echo '</div>'; //#app_info

          echo '<div id="app_emergency" class="app_form">';
            show_meta_box($emergency_contact_fields);
          echo '</div>';

          echo '<div id="app_tos" class="app_form">';
            show_meta_box($term_of_service_fields);
          echo '</div>'; //#app_tos
        ?>

        <div id="bot_nav">
          <div id="bot_prev">
            <button class="bot_btn" type="previous"><?php _e('Previous', 'coco')?></button>
          </div>

          <div id="bot_submit">
    				<button class="bot_btn" type="null"><?php _e('Submit', 'coco') ?></button>
          </div>

          <div id="bot_next">
            <button class="bot_btn" type="next"><?php _e('Next', 'coco')?></button>
          </div>
        </div>

      </form>


    <?php

      function show_meta_box($meta_fields) {
        global $post;
        // Use nonce for verification
        echo '<input type="hidden" name="custom_meta_box_nonce" value="'.wp_create_nonce(basename(__FILE__)).'" />';

          // Begin the field table and loop
          echo '<table class="volunteer_app">';

          echo '<thead>';
              echo '<tr><th colspan="'.$meta_fields[0]['colspan'].'">
                    <h2>'.$meta_fields[0]['header'].'</h2>
                    </th></tr>';

              if($meta_fields[0]['desc']){
                echo '<tr>
                      <th colspan="'.$meta_fields[0]['colspan'].'">'.$meta_fields[0]['desc'].'</th>
                      </tr>';
              }
          echo '</thead>';

          foreach ($meta_fields as $field) {
              // get value of this field if it exists for this post
              $meta = get_post_meta($post->ID, $field['id'], true);

                  switch($field['type']) {

                      // TEXT
                      case 'text':
                          // right column
                          echo '<td colspan="'.$field['colspan'].'">
                                <label for="'.$field['id'].'">'.$field['label'].'</label>
                                <input type="text" class="input" name="'.$field['id'].'" id="'.$field['id'].'"
                                value="'.$meta.'" size="30" readonly="readonly"',
                                $field['required'] ? ' required="required"' : '', ' />
                                <svg class="input-line" viewBox="0 0 40 2" preserveAspectRatio="none">
                                    <path d="M0 1 L40 1"/>
                                    <path d="M0 1 L40 1" class="focus"/>
                                    <path d="M0 1 L40 1" class="invalid"/>
                                    <path d="M0 1 L40 1" class="valid"/>
                                </svg>
                                </td>';
                          break;


                      // DATE
                      case 'date':
                          // right column
                          echo '<td colspan="'.$field['colspan'].'">
                                <label for="'.$field['id'].'">'.$field['label'].'</label>
                                <input type="date" class="input" name="'.$field['id'].'" id="'.$field['id'].'"
                                value="'.$meta.'" size="30" readonly="readonly"',
                                $field['required'] == "yes" ? ' required="required"' : '', '/>
                                <svg class="input-line" viewBox="0 0 40 2" preserveAspectRatio="none">
                                    <path d="M0 1 L40 1"/>
                                    <path d="M0 1 L40 1" class="focus"/>
                                    <path d="M0 1 L40 1" class="invalid"/>
                                    <path d="M0 1 L40 1" class="valid"/>
                                </svg>
                                </td>';

                          break;

                      // EMAIL
                      case 'email':
                          // right column
                          echo '<td colspan="'.$field['colspan'].'">
                                <label for="'.$field['id'].'">'.$field['label'].'</label>
                                <input type="email" class="input" name="'.$field['id'].'" id="'.$field['id'].'"
                                value="'.$meta.'" size="30" readonly="readonly"',
                                $field['required'] == "yes" ? ' required="required"' : '', '/>
                                <svg class="input-line" viewBox="0 0 40 2" preserveAspectRatio="none">
                                    <path d="M0 1 L40 1"/>
                                    <path d="M0 1 L40 1" class="focus"/>
                                    <path d="M0 1 L40 1" class="invalid"/>
                                    <path d="M0 1 L40 1" class="valid"/>
                                </svg>
                                </td>';

                          break;

                      // TEXTAREA
                      case 'textarea':
                          // right column
                          echo '<td colspan="'.$field['colspan'].'">
                                <label for="'.$field['id'].'">'.$field['label'].'</label>
                                <textarea name="'.$field['id'].'" id="'.$field['id'].'"
                                cols="60" rows="4" readonly="readonly">'.$meta.'</textarea>
                                </td>';
                      break;

                      // CHECKBOX_GROUP
                      case 'checkbox_group':
                          // right column
                          echo '<td colspan="'.$field['colspan'].'">
                                <label for="'.$field['id'].'">'.$field['label'].'</label>';
                          foreach ($field['options'] as $option) {
                              echo '<span class="vol_check_group nowrap">
                                    <input type="checkbox" name="'.$field['id'].'[]"
                                      id="'.$option['value'].'" value="'.$option['value'].'" disabled="disabled"',
                                      $meta && in_array($option['value'], $meta) ? ' checked="checked"' : '',' />
                                    <label for="'.$option['value'].'">'.$option['label'].'</label></span>';
                          }
                          echo '</td>';
                      break;

                      // radio
                      case 'radio':
                          //right column
                          echo '<td colspan="'.$field['colspan'].'">
                                <label for="'.$field['id'].'">'.$field['label'].'</label>';
                          foreach ( $field['options'] as $option ) {
                              echo '<span class="nowrap vol_radio">
                                    <input type="radio" name="'.$field['id'].'"
                                      id="'.$option['value'].'" value="'.$option['value'].'" disabled="disabled"',
                                      $meta == $option['value'] ? ' checked="checked"' : '',' />
                                    <label for="'.$option['value'].'">'.$option['label'].'</label></span>';
                          }
                          echo '</td>';
                      break;

                } //end switch


                //START A NEW ROW
                if($field['break']){
                  echo '</tr><tr>';
                }

          } // end foreach

          echo '</tr>';
          echo '</table>'; // end table
      } // show_meta_box

    ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
