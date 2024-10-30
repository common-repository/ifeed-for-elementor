<div class="wrap iffe-wrap">
    <div class="options_wrap">

        <h2><?php echo esc_html__( 'iFeed For Elementor', 'ifeed-for-elementor' ); ?></h2>


    <form method="post" action="options.php">

        <?php 

        settings_fields( 'iffe_option_group' ); 

        $options = get_option( 'iffe_options' ); 

        ?>
        <div class="options_wrap_full">
            <h3 class="sub-title"><?php echo esc_html__( 'General Settings', 'ifeed-for-elementor' ); ?></h3>

            <div class="options_input options_text">      
                <span class="labels">
                    <label for="username"><?php echo esc_html__( 'Instagram Username', 'ifeed-for-elementor' ); ?></label>
                </span>
                <input name="iffe_options[username]" id="username" type="text" value="<?php if ( isset( $options['username']) ){ echo esc_attr($options['username']);  } ?>">
            </div>

            <div class="options_input options_text">      
                <span class="labels">
                    <label for="access_token"><?php echo esc_html__( 'Access Token', 'ifeed-for-elementor' ); ?></label>
                </span>

                <?php
                    if(isset($_GET['access_token'])){
                        $access_token = esc_html( $_GET['access_token'] );
                    }elseif(isset($options['access_token']) && $options['access_token'] !=''){
                        $access_token = esc_html( $options['access_token'] );
                    }else{
                        $access_token = '';
                    }
                ?>

                <input name="iffe_options[access_token]" id="access_token" type="text" value="<?php echo esc_attr($access_token); ?>">

                <?php $return_url = urlencode(admin_url('admin.php?page=ifeed-for-elementor')) . '&response_type=token&state='. admin_url('admin.php?ifeed-for-elementor'); ?>

                <small>
                    <?php echo esc_html__( 'Please enter the Instagram Access Token. Click the link below to get your Instagram access token.', 'ifeed-for-elementor' ); ?>
                    <a href="<?php echo esc_url( 'https://api.instagram.com/oauth/authorize/?client_id=671c452b7ca543fbb74a2c616382d27d&scope=basic&redirect_uri=http://api.web-dorado.com/instagram?return_url='.$return_url ) ?>"><?php echo esc_html__( 'Get Access Token', 'ifeed-for-elementor' ); ?></a>
                </small>
            </div>
        </div>

        <div class="clearfix"></div>
        <span class="submit">
            <input class="button button-primary" type="submit" name="save" value="<?php _e('Save All Changes', 'ifeed-for-elementor') ?>" />
        </span>
    </form>
    </div>

    <div class="sidebox first-sidebox"> 

        <h3><?php echo esc_html__( 'Instruction to use Plugin', 'ifeed-for-elementor' ); ?></h3>

        <hr />

        <p><?php echo esc_html__( 'Go to Elementor page customization panel', 'ifeed-for-elementor' ); ?></p>

        <p><?php echo esc_html__( 'Scroll down and find iFeed Elements', 'ifeed-for-elementor' ); ?></p>

        <p><?php echo esc_html__( 'You will find Instagram Feed added under iFeed Elements', 'ifeed-for-elementor' ); ?></p>

        <p><?php echo esc_html__( 'Drag and drop Instagram Feed on the section you want to dispaly feed', 'ifeed-for-elementor' ); ?></p>

    </div>

</div>