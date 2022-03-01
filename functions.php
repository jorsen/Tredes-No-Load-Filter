// function that runs when shortcode is called
function archi_job_board()
{
    ob_start(); ?>

    <style type="text/css">
        .cstm-search {
            max-width: 50%;
        }
        .card {
            padding: 0px 5%;
        }
    .cstm-search {
    display: grid;
    grid-template-columns: 1fr 1fr 1fr;
    padding: 2% 3%;
} 
    .active p.cstm-type {
    font-size: 21px;
}
.active h4.cstm-event-title {
    font-size: 21px;
}
.active .cstm-col-2 h4 {
    font-size: 29px;
}
    .accordion:nth-child(4n + 1) {
        background-color: #00F1E7;
    }
    .accordion:nth-child(4n + 2) {
    background-color: #00DFEA;
    }
    .accordion:nth-child(4n + 3) {
        background-color: #2DCDBD;
    }
    .accordion:nth-child(4n + 4) {
        background-color: #00F295;
    }
    .accordion-content {
      max-height: 0;
      transition: 1s ease;
      overflow-y: hidden;
    }
    .accordion-header {
    display: grid;
    grid-template-columns: 1fr 1fr 1fr;
    padding: 1% 3% 1%;
    cursor: pointer;
    align-items: center;
}
.active .accordion-header {
    display: grid;
    grid-template-columns: 1fr 1.25fr 1fr;
    padding: 1% 3% 1%;
    cursor: pointer;
    align-items: center;
}
p.cstm-days {
    margin-bottom: 0px;
    text-align: right;
}
    .cstm-description {
    padding: 0% 3%;
    display: grid;
    grid-template-columns: 1fr 2.25fr;
    }

    h2.premium {
    font-family: 'Calibri';
    font-weight: 300;
    font-size: 30px;
    background-color: #8B69F1;
    padding: 1% 3%;
    color: white;
    margin: 0px;
}
.active .accordion-header {
    padding: 1% 3% 0%;
    cursor: pointer;
}
h4.cstm-event-title {
    font-family: 'Calibri';
    font-weight: 600;
    font-size: 19px;
    color: black;
}
.sharebtn {
    display: inline-grid;
    width: 220px;
        margin-top: 30px;
}
.sharebtn button a {
    color: black;
    font-size: 22px;
}
.sharebtn button {
    margin: 10px 0px;
    border: 1px solid black;
}
.sharebtn button:hover a {
    color: white;
    font-size: 22px;
    font-family: 'Calibre';
    font-weight: 300;
}
.sharebtn button:hover {
    background-color: black;
}
.cstm-col-2 h4 {
  font-family: 'Calibri';
    font-weight: 600;
    font-size: 19px;
    color: black;
}
.sharebtn {
    display: inline-grid;
}
.sharebtn button {
    margin: 10px 0px;
}
    h3.cstm-event-title {
    margin: 0;
    }
    .cstm-col-1 {
    margin: 0;
    padding: 0;
    }
    ul.filter-option {
        list-style: none;
        padding: 0;
    }
    ul label{
        padding-left:10px;
    }
    .accordion.active .accordion-content{
      max-height: revert;
    }
    .description-text {
    padding-top: 5%;
    }
    .upcoming-post.filter-active .accordion.filtered {
      display: none;
    }
    </style>


        <?php
        echo do_shortcode("[job_filter]");

        if ($_GET["category"]) {
            $category = $_GET["category"];
        } else {
            $category = "";
        }
        if ($_GET['newsletter']) {
            $newsletter = $_GET['newsletter'];
        } else {
            $newsletter = '';
        }
        if ($_GET["search"]) {
            $search = $_GET["search"];
        } else {
            $search = "";
        }

        $options = [
            "post_type" => "jobs_board",
            "order" => "desc",
            "posts_per_page" => "6",
            "newsletter" => $newsletter,
            "category_name" => $category,
            "s" => $search,
        ];

        $query = new WP_Query($options);
        ?>
        <h2 class="premium">Premium Listings</h2>
        <?php 
        if ($query->have_posts()) { ?>

        <div class="upcoming-post">
                <!-- <h2>Blog</h2> -->
                <?php while ($query->have_posts()) {

                    $query->the_post();
                    $level = get_the_terms( $post->ID, 'level' );
                    $role = get_the_terms( $post->ID, 'role_category' );
                    $type = get_the_terms( $post->ID, 'type_category' );
                    $output = "";
                    $separator = ", ";

                    if (!empty($type)) {
                    foreach ($type as $category) {
                        $output .= esc_html($category->name).$separator;
                      }
                  }
                    
                    $results = $arrayName = array(
                      'level' => array(),
                      'role' => array(),
                      'type' => array() 
                    );


                    if (!empty($level)) {
                      foreach ($level as $val) {
                            array_push($results['level'], esc_html($val->name));
                      }
                    }
                    if (!empty($role)) {
                      foreach ($role as $val) {
                          array_push($results['role'],esc_html($val->name));

                      }
                    }
                    if (!empty($type)) {
                      foreach ($type as $val) {
                          array_push($results['type'], esc_html($val->name));
                      }
                    }
                ?>

                <div class="accordion" 
                  data-level="<?php echo join("|", $results['level']) ?>" 
                  data-role="<?php echo join("|", $results['role']) ?>" 
                  data-type="<?php echo join("|", $results['type']) ?>">
                    <div class="accordion-header">
                        <div class="cstm-col-1">
                        <?php
                            echo '<h4 class="cstm-event-title">' . get_the_title() . "</h4>"; 
                            echo '<p class="cstm-type">'.trim($output ,$separator).'</p>';
                        ?>
                      </div>
                      <div class="cstm-col-2">
                        <?php
                            echo '<h4>', the_field('company_name'). '</h4>'; 
                            echo the_field('location');
                        ?>
                      </div>
                      <div class="cstm-col-3">
                        <?php 
                          $today = date("Y/m/d");
                          $published_date = get_the_date();

                          $datediff = strtotime($today) - strtotime($published_date);

                          $number_of_days_publish =  round($datediff / (60 * 60 * 24));

                          if($number_of_days_publish == 0){
                            $daysAgo = "Today";
                          }else{
                            $daysAgo = $number_of_days_publish." days ago";
                          }
                        ?>
                        <p class="cstm-days"><?php echo $daysAgo ?></p>
                      </div>
          </div>
          <div class="accordion-content">
            <div class="cstm-description">
                <div class="cstm-col-1">
                    <div class="salary"> 
                    <?php 
                        echo the_field('salary');
                    ?>
                    </div>
                      <div class="sharebtn">
                        <button><a href="mailto:<?php echo the_field('admin_contact_email') ?>">Apply by email</a></button>
                        <button><a href="<?php echo the_field('website') ?>" target="_blank">Visit Website</a></button>
                        <button><a href="">Share to friend</a></button>
                        <button><a href="<?php echo the_field('twitter') ?>" target="_blank">Tweet this Job</a></button>
                      </div>
                    
                </div>

                <div class="cstm-col-2">
                  <?php

                    $excerpt = '<div class="description-text">'.get_the_content().'</div>';

                    // $excerpt = substr($excerpt, 0, 260);
                    // $result = substr($excerpt, 0, strrpos($excerpt, " "));
                    echo $excerpt;
                    ?>
                </div>

            </div>
          </div>
        </div>

                <?php } ?>
      </div>
    <script>
      const accordions = [...document.querySelectorAll(".accordion")]
      accordions.forEach(item => {
        const heading = item.querySelector(".accordion-header")
        heading.addEventListener('click', function(){
      if(document.querySelector('.accordion.active') != item) {
        accordions.forEach(a => a.classList.remove('active'))
      }
      item.classList.toggle('active')
        })
      })
    
    
function getCheckedBoxes(chkboxName) {
    var checkboxes = document.getElementsByName(chkboxName);
    var checkboxesChecked = [];
    // loop over them all
    for (var i = 0; i < checkboxes.length; i++) {
        // And stick the checked ones onto an array...
        if (checkboxes[i].checked) {
            checkboxesChecked.push(checkboxes[i].value);
        }
    }
    // Return the array if it is non-empty, or null
    return checkboxesChecked.length > 0 ? checkboxesChecked : null;
}

const filters = [...document.querySelectorAll('.filter-option input[type="checkbox"]')]
const parentEl = document.querySelector(".upcoming-post")

filters.forEach(filter => {
    filter.addEventListener('input', function () {
        const levels = getCheckedBoxes('Level')
        const roles = getCheckedBoxes('Role')
        const types = getCheckedBoxes('Type')
        const active = levels || roles || types


        if (active) {
            parentEl.classList.add('filter-active')
            accordions.forEach(accordion => {
                const _levels = accordion.getAttribute('data-level')
                const _roles = accordion.getAttribute('data-role')
                const _types = accordion.getAttribute('data-type')
                var isFiltered = true

                if(levels)
                _levels.split('|').forEach(v => {
                    levels.forEach(_v => {
                        if(v.toLowerCase().replaceAll(' ', '-').indexOf(_v) >= 0) isFiltered = false

                    })
                })

                if(roles)
                _roles.split('|').forEach(v => {
                    roles.forEach(_v => {
                        if(v.toLowerCase().replaceAll(' ', '-').indexOf(_v) >= 0) isFiltered = false
                    })
                })

                if(types)
                _types.split('|').forEach(v => {
                    types.forEach(_v => {
                        if(v.toLowerCase().replaceAll(' ', '-').indexOf(_v) >= 0) isFiltered = false
                    })
                })
                
                if(isFiltered) accordion.classList.add('filtered')
                else accordion.classList.remove('filtered')
            })
        } else {
            parentEl.classList.remove('filter-active')
        }

    })
})
    </script>

<?php
            
            echo "</div>";
        }
        wp_reset_postdata();
?>

<?php // $output = ob_get_clean();

    return ob_get_clean();
}
// register shortcode
add_shortcode('job_board', 'archi_job_board');
add_filter('widget_text', 'do_shortcode');
