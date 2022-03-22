<?php
global $wpdb;

if ( !defined( 'ABSPATH' ) ) {
        die( __( "Can't load this file directly", 'vj-wp-import-export' ) );
}

if ( file_exists( WPIE_EXPORT_CLASSES_DIR . '/class-wpie-export.php' ) ) {
        require_once(WPIE_EXPORT_CLASSES_DIR . '/class-wpie-export.php');
}
$wpie_export = new \wpie\export\WPIE_Export();

$export_type = $wpie_export->get_export_type();

$wpie_taxonomies_list = $wpie_export->wpie_get_taxonomies();

$attribute_taxonomies = null;
if ( class_exists( "WooCommerce" ) ) {
        $attribute_taxonomies = $wpie_export->get_attribute_list();
}
unset( $wpie_export );

$advance_options_files = apply_filters( 'wpie_export_advance_option_files', array() );

$extension_html_files = apply_filters( 'wpie_add_export_extension_files', array() );

$extension_process_btn = apply_filters( 'wpie_add_export_extension_process_btn', array() );

$wpie_remote_data = apply_filters( 'wpie_get_export_remote_locations', array() );

?>
<div class="wpie_main_container wpie_export_init_step">
        <div class="wpie_content_header">
                <div class="wpie_content_header_inner_wrapper">
                        <div class="wpie_content_header_title"><?php esc_html_e( 'New Export', 'vj-wp-import-export' ); ?></div>
                        <div class="wpie_total_records_wrapper">
                                <div class="wpie_total_record_text"><?php esc_html_e( 'Total Records Found', 'vj-wp-import-export' ); ?></div>
                                <div class="wpie_total_records_outer"><span class="wpie_total_records wpie_total_records_container"></span></div>
                        </div>
                        <div class="wpie_fixed_header_button">
                                <div class="wpie_btn wpie_btn_primary wpie_export_preview_btn">
                                        <i class="fas fa-eye wpie_general_btn_icon " aria-hidden="true"></i><?php esc_html_e( 'Preview', 'vj-wp-import-export' ); ?>
                                </div>
                                <div class="wpie_btn wpie_btn_primary wpie_migrate_export_data_btn">
                                        <i class="fas fa-exchange-alt wpie_general_btn_icon " aria-hidden="true"></i><?php esc_html_e( 'Export With Settings For Import', 'vj-wp-import-export' ); ?>
                                </div>
                                <div class="wpie_btn wpie_btn_primary wpie_export_data_btn">
                                        <i class="fas fa-file-export wpie_general_btn_icon " aria-hidden="true"></i><?php esc_html_e( 'Export', 'vj-wp-import-export' ); ?>
                                </div>
                        </div>
                </div>
        </div>
        <div class="wpie_content_wrapper">
                <form class="wpie_export_frm" method="post" action="#">
                        <input type="hidden" name="wpie_total_filter_records" value="0" class="wpie_total_filter_records">
                        <input type="hidden" name="fields_data" value="" class="wpie_export_fields_data">
                        <input type="hidden" name="wpie_filter_rule" value="" class="wpie_filter_rule">
                        <input type="hidden" name="wpie_export_condition" value="" class="wpie_export_condition">
                        <div class="wpie_content_data_choose">
                                <div class="wpie_section_wrapper wpie_choose_export_container">
                                        <div class="wpie_content_data_header wpie_section_wrapper_selected">
                                                <div class="wpie_content_title"><?php esc_html_e( 'Choose what to export', 'vj-wp-import-export' ); ?></div>
                                                <div class="wpie_layout_header_icon_wrapper"><i class="fas fa-chevron-up wpie_layout_header_icon wpie_layout_header_icon_collapsed" aria-hidden="true"></i><i class="fas fa-chevron-down wpie_layout_header_icon wpie_layout_header_icon_expand" aria-hidden="true"></i></div>
                                        </div>
                                        <div class="wpie_section_content" style="display: block;">
                                                <div class="wpie_content_data_wrapper">
                                                        <select class="wpie_content_data_select wpie_export_type_select" name="wpie_export_type">
                                                                <option value=""><?php esc_html_e( 'Select Export Type', 'vj-wp-import-export' ); ?></option>
                                                                <?php if ( !empty( $export_type ) ) {

                                                                        ?>                       
                                                                        <?php foreach ( $export_type as $key => $label ) {

                                                                                ?>
                                                                                <option value="<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $label ); ?></option>
                                                                        <?php } ?>
                                                                <?php } ?>
                                                        </select>
                                                </div>
                                                <div class="wpie_content_data_wrapper wpie_taxonomies_types_wrapper wpie_sub_type_wrapper">
                                                        <select class="wpie_content_data_select wpie_taxonomies_types_select" name="wpie_taxonomy_type">
                                                                <option value=""><?php esc_html_e( 'Select Taxonomy', 'vj-wp-import-export' ); ?></option>
                                                                <?php if ( !empty( $wpie_taxonomies_list ) ) {

                                                                        ?>                       
                                                                        <?php foreach ( $wpie_taxonomies_list as $slug => $name ) {

                                                                                ?>
                                                                                <option value="<?php echo esc_attr( $slug ); ?>"><?php echo esc_html( $name ); ?></option>
                                                                        <?php } ?>
                                                                <?php } ?>
                                                        </select>
                                                </div>
                                                <div class="wpie_content_data_wrapper wpie_attribute_taxonomies_wrapper wpie_sub_type_wrapper">
                                                        <select class="wpie_content_data_select wpie_attribute_taxonomies_select" data-placeholder="<?php esc_html_e( 'All Attributes', 'vj-wp-import-export' ); ?>" name="wpie_attribute_taxonomy[]"  multiple="multiple">
                                                            <?php if ( !empty( $attribute_taxonomies ) ) {

                                                                    ?>                       
                                                                    <?php foreach ( $attribute_taxonomies as $attribute ) {

                                                                            ?>
                                                                                <option value="<?php echo isset( $attribute->attribute_name ) ? esc_attr( $attribute->attribute_name ) : ""; ?>" ><?php echo isset( $attribute->attribute_label ) ? esc_html( $attribute->attribute_label ) : ""; ?></option>
                                                                        <?php } ?>
                                                                <?php } ?>
                                                        </select>
                                                        <div class="wpie_export_default_hint"><?php esc_html_e( 'Default : All Attributes.', 'vj-wp-import-export' ); ?></div>
                                                </div>
                                        </div>
                                </div>
                        </div>
                        <div class="wpie_filter_and_option_header"><?php esc_html_e( 'Apply Filters & Options', 'vj-wp-import-export' ); ?></div>
                        <div class="wpie_content_data">

                                <div class="wpie_section_wrapper wpie_filter_section_wrapper">
                                        <div class="wpie_content_data_header">
                                                <div class="wpie_content_title"><?php esc_html_e( 'Add filtering options', 'vj-wp-import-export' ); ?></div>
                                                <div class="wpie_layout_header_icon_wrapper"><i class="fas fa-chevron-up wpie_layout_header_icon wpie_layout_header_icon_collapsed" aria-hidden="true"></i><i class="fas fa-chevron-down wpie_layout_header_icon wpie_layout_header_icon_expand" aria-hidden="true"></i></div>
                                        </div>
                                        <div class="wpie_section_content wpie_field_selection_wrapper">
                                                <div class="wpie_content_data_wrapper">
                                                        <div class="wpie_content_data_rule_header_wrapper">
                                                                <div class="wpie_content_data_rule_header"><?php esc_html_e( 'Element', 'vj-wp-import-export' ); ?></div>
                                                                <div class="wpie_content_data_rule_header"><?php esc_html_e( 'Rule', 'vj-wp-import-export' ); ?></div>
                                                                <div class="wpie_content_data_rule_header"><?php esc_html_e( 'Value', 'vj-wp-import-export' ); ?></div>
                                                                <div class="wpie_content_data_rule_btn_header"></div>
                                                        </div>
                                                        <div class="wpie_content_data_rule_wrapper ">
                                                                <div class="wpie_content_data_rule">
                                                                        <select class="wpie_content_data_select wpie_content_data_rule_fields">
                                                                                <option value=""><?php esc_html_e( 'Select Element', 'vj-wp-import-export' ); ?></option>
                                                                        </select>
                                                                </div>
                                                                <div class="wpie_content_data_rule wpie_content_data_rule_condition">
                                                                        <select class="wpie_content_data_select wpie_content_data_rule_select">
                                                                                <option value=""><?php esc_html_e( 'Select Rule', 'vj-wp-import-export' ); ?></option>
                                                                        </select>
                                                                </div>
                                                                <div class="wpie_content_data_rule">
                                                                        <input type="text" class="wpie_content_data_input wpie_content_data_rule_value" value=""/>
                                                                        <div class="wpie_value_hints_container">
                                                                                <div class="wpie_value_hints">
                                                                                    <?php esc_html_e( 'Dynamic date allowed', 'vj-wp-import-export' ); ?>
                                                                                </div>
                                                                                <div class="wpie_value_hints">
                                                                                        <?php esc_html_e( 'Example :', 'vj-wp-import-export' ); ?> yesterday, today, tomorrow...
                                                                                </div>
                                                                                <div class="wpie_value_hints">
                                                                                        <?php esc_html_e( 'For more click', 'vj-wp-import-export' ); ?> <a target="_blank" href="<?php echo esc_url( 'https://www.php.net/manual/en/datetime.formats.relative.php' ); ?>"><?php esc_html_e( 'here', 'vj-wp-import-export' ); ?> </a>
                                                                                </div>                                        
                                                                        </div>
                                                                </div>
                                                                <div class="wpie_content_data_rule_btn_wrapper"> 
                                                                        <a class="wpie_icon_btn  wpie_save_add_rule_btn">
                                                                                <i class="fas fa-plus wpie_icon_btn_icon " aria-hidden="true"></i>
                                                                        </a>
                                                                </div>
                                                        </div>
                                                        <div class="wpie_content_added_data_rule_wrapper">
                                                                <table class="wpie_content_added_data_rule table table-bordered">

                                                                </table>
                                                        </div>
                                                </div>
                                        </div>
                                </div>
                                <div class="wpie_section_wrapper">
                                        <div class="wpie_content_data_header">
                                                <div class="wpie_content_title"><?php esc_html_e( 'Choose Fields', 'vj-wp-import-export' ); ?></div>
                                                <div class="wpie_layout_header_icon_wrapper"><i class="fas fa-chevron-up wpie_layout_header_icon wpie_layout_header_icon_collapsed" aria-hidden="true"></i><i class="fas fa-chevron-down wpie_layout_header_icon wpie_layout_header_icon_expand" aria-hidden="true"></i></div>
                                        </div>
                                        <div class="wpie_section_content">
                                                <div class="wpie_content_data_wrapper">
                                                        <div class="wpie_export_fields_hint"><?php esc_html_e( 'Use click on text for edit field. Use Drag and Drop for change any position', 'vj-wp-import-export' ); ?></div>
                                                        <div class="wpie_field_selection"></div>
                                                        <div class="wpie_fields_selection_btn_wrapper">
                                                                <div class="wpie_btn wpie_btn_secondary wpie_btn_radius wpie_fields_add_new" >
                                                                        <i class="fas fa-plus wpie_general_btn_icon " aria-hidden="true"></i><?php esc_html_e( 'Add', 'vj-wp-import-export' ); ?>
                                                                </div>
                                                                <div class="wpie_btn wpie_btn_secondary wpie_btn_radius wpie_add_bulk_fields">
                                                                        <i class="fas fa-plus wpie_general_btn_icon " aria-hidden="true"></i></i><?php esc_html_e( 'Add Bulk', 'vj-wp-import-export' ); ?>
                                                                </div>
                                                                <div class="wpie_btn wpie_btn_secondary wpie_btn_radius wpie_fields_add_all">
                                                                        <i class="fas fa-plus wpie_general_btn_icon " aria-hidden="true"></i></i><?php esc_html_e( 'Add All', 'vj-wp-import-export' ); ?>
                                                                </div>
                                                                <div class="wpie_btn wpie_btn_secondary wpie_btn_radius wpie_fields_remove_all">
                                                                        <i class="fas fa-times wpie_general_btn_icon " aria-hidden="true"></i><?php esc_html_e( 'Remove All', 'vj-wp-import-export' ); ?>
                                                                </div>
                                                        </div>
                                                </div>
                                        </div>
                                </div>

                                <div class="wpie_section_wrapper">
                                        <div class="wpie_content_data_header">
                                                <div class="wpie_content_title"><?php esc_html_e( 'Advanced Options', 'vj-wp-import-export' ); ?></div>
                                                <div class="wpie_layout_header_icon_wrapper"><i class="fas fa-chevron-up wpie_layout_header_icon wpie_layout_header_icon_collapsed" aria-hidden="true"></i><i class="fas fa-chevron-down wpie_layout_header_icon wpie_layout_header_icon_expand" aria-hidden="true"></i></div>
                                        </div>
                                        <div class="wpie_section_content">
                                                <div class="wpie_content_data_wrapper">
                                                        <table class="wpie_content_data_tbl table-bordered">
                                                                <tr>
                                                                        <td >
                                                                                <div class="wpie_options_data">
                                                                                        <div class="wpie_options_data_title"><?php esc_html_e( 'Export File Type', 'vj-wp-import-export' ); ?></div>
                                                                                        <div class="wpie_options_data_content">
                                                                                                <select class="wpie_content_data_select wpie_export_file_type" name="wpie_export_file_type">
                                                                                                        <option value=""><?php esc_html_e( 'Choose Export file type', 'vj-wp-import-export' ); ?></option>
                                                                                                        <option value="csv"><?php esc_html_e( 'CSV', 'vj-wp-import-export' ); ?></option>
                                                                                                        <option value="xls"><?php esc_html_e( 'XLS', 'vj-wp-import-export' ); ?></option>
                                                                                                        <option value="xlsx"><?php esc_html_e( 'XLSX', 'vj-wp-import-export' ); ?></option>
                                                                                                        <option value="xml"><?php esc_html_e( 'XML', 'vj-wp-import-export' ); ?></option>
                                                                                                        <option value="ods"><?php esc_html_e( 'ODS', 'vj-wp-import-export' ); ?></option>
                                                                                                        <option value="json"><?php esc_html_e( 'JSON', 'vj-wp-import-export' ); ?></option>
                                                                                                </select>
                                                                                                <div class="wpie_export_default_hint"><?php esc_html_e( 'Default : CSV', 'vj-wp-import-export' ); ?></div>
                                                                                        </div>
                                                                                </div>
                                                                        </td>
                                                                        <td>
                                                                                <div class="wpie_options_data wpie_csv_field_separator_wrapper">
                                                                                        <div class="wpie_options_data_title"><?php esc_html_e( 'Field Separator', 'vj-wp-import-export' ); ?></div>
                                                                                        <div class="wpie_options_data_content">
                                                                                                <input type="text" class="wpie_content_data_input wpie_csv_field_separator" value="," name="wpie_csv_field_separator"/>
                                                                                                <div class="wpie_export_default_hint"><?php esc_html_e( 'Default : , (Comma)', 'vj-wp-import-export' ); ?></div>
                                                                                        </div>
                                                                                </div>
                                                                        </td>
                                                                </tr>
                                                                <tr>
                                                                        <td>
                                                                                <div class="wpie_options_data">
                                                                                        <div class="wpie_options_data_title"><?php esc_html_e( 'Export File Name', 'vj-wp-import-export' ); ?></div>
                                                                                        <div class="wpie_options_data_content">
                                                                                                <input type="text" class="wpie_content_data_input wpie_export_file_name" value="" name="wpie_export_file_name"/>
                                                                                                <div class="wpie_export_default_hint"><?php esc_html_e( 'Default : Auto Generated', 'vj-wp-import-export' ); ?></div>
                                                                                        </div>
                                                                                </div>
                                                                        </td>
                                                                        <td>
                                                                                <div class="wpie_options_data">
                                                                                        <div class="wpie_options_data_title"><?php esc_html_e( 'Records Per iteration', 'vj-wp-import-export' ); ?><i class="far fa-question-circle wpie_data_tipso" data-tipso="<?php esc_attr_e( "WP Import Export must be able to process this many records in less than your server's timeout settings. If your export fails before completion, to troubleshoot you should lower this number.", "vj-wp-import-export" ); ?>"></i></div>
                                                                                        <div class="wpie_options_data_content">
                                                                                                <input type="text" class="wpie_content_data_input wpie_records_per_iteration" value="50" name="wpie_records_per_iteration"/>
                                                                                                <div class="wpie_export_default_hint"><?php esc_html_e( 'Default : 50', 'vj-wp-import-export' ); ?></div>
                                                                                        </div>
                                                                                </div>
                                                                        </td>
                                                                </tr>
                                                                <tr>
                                                                        <td>
                                                                                <div class="wpie_options_data">
                                                                                        <div class="wpie_options_data_title"><?php esc_html_e( 'File path for extra copy in WordPress upload directory', 'vj-wp-import-export' ); ?><i class="far fa-question-circle wpie_data_tipso" data-tipso="<?php echo esc_attr( __( "Enter relative path to", "vj-wp-import-export" ) . " " . WPIE_SITE_UPLOAD_DIR . " " . __( "Enter only path that not include file name. it's useful when you sync any export data with import. Path folders must be exist", "vj-wp-import-export" ) ); ?>"></i></div>
                                                                                        <div class="wpie_options_data_content">
                                                                                                <input type="text" class="wpie_content_data_input extra_copy_path" value="" name="extra_copy_path"/>
                                                                                                <div class="wpie_export_default_hint"><?php esc_html_e( 'Default : empty', 'vj-wp-import-export' ); ?></div>
                                                                                        </div>
                                                                                </div>
                                                                        </td>
                                                                        <td>
                                                                                <div class="wpie_options_data">
                                                                                        <div class="wpie_options_data_title"><?php esc_html_e( 'Include BOM', 'vj-wp-import-export' ); ?><i class="far fa-question-circle wpie_data_tipso" data-tipso="<?php esc_attr_e( "The BOM will help some programs like Microsoft Excel read your export file if it includes non-English characters.", "vj-wp-import-export" ); ?>"></i></div>
                                                                                        <div class="wpie_options_data_content">
                                                                                                <input type="checkbox" class="wpie_export_include_bom_chk wpie_checkbox wpie_export_include_bom" id="wpie_export_include_bom" name="wpie_export_include_bom" value="1"/>
                                                                                                <label for="wpie_export_include_bom" class="wpie_options_data_title_email wpie_checkbox_label"><?php esc_html_e( 'Include BOM in export file', 'vj-wp-import-export' ); ?></label>

                                                                                        </div>
                                                                                </div>
                                                                        </td>
                                                                </tr>
                                                                <tr class="wpie_skip_empty_nodes_wrapper">
                                                                        <td colspan="2">
                                                                                <div class="wpie_options_data">
                                                                                        <div class="wpie_options_data_content">
                                                                                                <input type="checkbox" class="wpie_export_include_bom_chk wpie_checkbox wpie_skip_empty_nodes" id="wpie_skip_empty_nodes" name="wpie_skip_empty_nodes" value="1" checked="checked"/>
                                                                                                <label for="wpie_skip_empty_nodes" class="wpie_options_data_title_email wpie_checkbox_label"><?php esc_html_e( 'Do not add Empty nodes in xml file', 'vj-wp-import-export' ); ?></label>
                                                                                                <i class="far fa-question-circle wpie_data_tipso" data-tipso="<?php esc_attr_e( "Plugin will not add empty value nodes", "vj-wp-import-export" ); ?>"></i>
                                                                                        </div>
                                                                                </div>
                                                                        </td>

                                                                </tr>
                                                                <?php
                                                                if ( !empty( $advance_options_files ) ) {

                                                                        $temp = 0;

                                                                        foreach ( $advance_options_files as $adv_options ) {

                                                                                if ( $temp % 2 == 0 ) {

                                                                                        ?>
                                                                                        <tr class="wpie_advance_options_row">
                                                                                            <?php
                                                                                    }
                                                                                    if ( file_exists( $adv_options ) ) {
                                                                                            include $adv_options;
                                                                                    }
                                                                                    if ( $temp % 2 == 0 ) {

                                                                                            ?>
                                                                                        </tr>
                                                                                        <?php
                                                                                }

                                                                                $temp++;
                                                                        }
                                                                }

                                                                ?>

                                                        </table>
                                                </div>
                                        </div>
                                </div>
                                <?php
                                if ( !empty( $extension_html_files ) ) {
                                        foreach ( $extension_html_files as $ext_html_file ) {
                                                if ( file_exists( $ext_html_file ) ) {
                                                        include $ext_html_file;
                                                }
                                        }
                                }

                                ?>
                        </div>
                        <div class="wpie_export_sidebar">
                                <div class="wpie_section_wrapper">
                                        <div class="wpie_content_data_header wpie_section_wrapper_selected">
                                                <div class="wpie_content_title"><?php esc_html_e( 'Load Settings', 'vj-wp-import-export' ); ?></div>
                                                <div class="wpie_layout_header_icon_wrapper"><i class="fas fa-chevron-up wpie_layout_header_icon wpie_layout_header_icon_collapsed" aria-hidden="true"></i><i class="fas fa-chevron-down wpie_layout_header_icon wpie_layout_header_icon_expand" aria-hidden="true"></i></div>
                                        </div>
                                        <div class="wpie_section_content" style="display: block;">
                                                <div class="wpie_load_template_wrapper">
                                                        <div class="wpie_load_template_label"><?php esc_html_e( 'From Saved Settings', 'vj-wp-import-export' ); ?></div>
                                                        <div class="wpie_content_data_wrapper wpie_template_list_wrapper">
                                                                <select class="wpie_content_data_select wpie_template_list_select" name="wpie_template_list">
                                                                        <option value=""><?php esc_html_e( 'Select Setting', 'vj-wp-import-export' ); ?></option>
                                                                </select>
                                                        </div>
                                                        <div class="wpie_update_template_btn_wrapper"> 
                                                                <div class="wpie_btn wpie_btn_secondary wpie_btn_radius wpie_update_template_btn">
                                                                        <i class="fas fa-check wpie_general_btn_icon " aria-hidden="true"></i><?php esc_html_e( 'Update', 'vj-wp-import-export' ); ?>
                                                                </div>
                                                        </div>
                                                </div>
                                                <div class="wpie_load_template_wrapper">
                                                        <div class="wpie_load_template_label"><?php esc_html_e( 'From Exports', 'vj-wp-import-export' ); ?></div>
                                                        <div class="wpie_content_data_wrapper wpie_export_settings_list_wrapper">
                                                                <select class="wpie_content_data_select wpie_export_settings_list_select" name="wpie_export_settings_list">
                                                                        <option value=""><?php esc_html_e( 'Select Setting', 'vj-wp-import-export' ); ?></option>
                                                                </select>
                                                        </div>                                                      
                                                </div>
                                        </div>
                                </div>
                                <div class="wpie_section_wrapper">
                                        <div class="wpie_content_data_header wpie_section_wrapper_selected">
                                                <div class="wpie_content_title"><?php esc_html_e( 'Save Setting', 'vj-wp-import-export' ); ?></div>
                                                <div class="wpie_layout_header_icon_wrapper"><i class="fas fa-chevron-up wpie_layout_header_icon wpie_layout_header_icon_collapsed" aria-hidden="true"></i><i class="fas fa-chevron-down wpie_layout_header_icon wpie_layout_header_icon_expand" aria-hidden="true"></i></div>
                                        </div>
                                        <div class="wpie_section_content" style="display: block;">
                                                <div class="wpie_load_template_label"><?php esc_html_e( 'Setting Name', 'vj-wp-import-export' ); ?></div>
                                                <div class="wpie_content_data_wrapper ">
                                                        <input type="text" class="wpie_content_data_input wpie_export_template_name" value="" name="wpie_template_name"/>
                                                </div>
                                                <div class="wpie_save_template_btn_wrapper"> 
                                                        <div class="wpie_btn wpie_btn_secondary wpie_btn_radius wpie_save_template_btn">
                                                                <i class="fas fa-check wpie_general_btn_icon " aria-hidden="true"></i><?php esc_html_e( 'Save', 'vj-wp-import-export' ); ?>
                                                        </div>
                                                </div>
                                        </div>
                                </div>
                        </div>
                </form>
        </div>
        <form class="wpie_file_download_action" method="post" action="#">
                <input type="hidden" class="wpie_download_export_id" name="wpie_download_export_id" value="0">
        </form>
</div>
<div class="wpie_doc_wrapper">
        <div class="wpie_doc_container">
                <a class="wpie_doc_url" href="<?php echo esc_url( WPIE_SUPPORT_URL ); ?>" target="_blank"><?php esc_html_e( 'Support', 'vj-wp-import-export' ); ?></a>
                <div class="wpie_doc_url_delim">|</div>
                <a class="wpie_doc_url" href="<?php echo esc_url( WPIE_DOC_URL ); ?>" target="_blank"><?php esc_html_e( 'Documentation', 'vj-wp-import-export' ); ?></a>
        </div>
</div>
<div class="wpie_loader wpie_hidden">
        <div></div>
        <div></div>
</div>
<!-- Modal -->
<div class="modal fade wpie_field_editor_model" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                        <div class="modal-header">
                                <h5 class="modal-title"><?php esc_html_e( 'Export Field Editor', 'vj-wp-import-export' ); ?></h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <i class="fas fa-times wpie_general_btn_icon " aria-hidden="true"></i>
                                </button>
                        </div>
                        <div class="modal-body">
                                <div class="wpie_export_field_editor_wrapper">
                                        <div class="wpie_export_field_editor_container">
                                                <div class="wpie_export_field_editor_title"><?php esc_html_e( 'Field Name', 'vj-wp-import-export' ); ?></div>
                                                <div class="wpie_export_field_editor_data_wrapper"><input type="text" class="wpie_content_data_input wpie_field_editor_data" value=""/></div>
                                        </div>
                                        <div class="wpie_export_field_editor_container">
                                                <div class="wpie_export_field_editor_title"><?php esc_html_e( 'Field value', 'vj-wp-import-export' ); ?></div>
                                                <div class="wpie_export_field_editor_data_wrapper wpie_content_data_wrapper">
                                                        <select class="wpie_content_data_select  wpie_content_data_field_list">
                                                        </select>
                                                </div>
                                        </div>
                                        <div class="wpie_export_field_editor_container wpie_field_editor_date_field_wrapper">
                                                <div class="wpie_export_field_editor_title"><?php esc_html_e( 'Date Format', 'vj-wp-import-export' ); ?></div>
                                                <div class="wpie_export_field_editor_data_wrapper wpie_content_data_wrapper">
                                                        <select class="wpie_content_data_select  wpie_field_editor_date_field">
                                                                <option value="unix"><?php esc_html_e( 'UNIX timestamp - PHP time()', 'vj-wp-import-export' ); ?></option>
                                                                <option value="php" selected="selected"><?php esc_html_e( 'Natural Language PHP date()', 'vj-wp-import-export' ); ?></option>
                                                        </select>
                                                        <div class="wpie_field_editor_date_field_format_wrapper">
                                                                <input type="text" class="wpie_content_data_input wpie_field_editor_date_field_format" value="" placeholder="<?php esc_attr_e( 'Y-m-d', 'vj-wp-import-export' ); ?>"/>
                                                                <div class="wpie_export_default_hint"><?php esc_html_e( 'Default : Site Date Format', 'vj-wp-import-export' ); ?></div>
                                                        </div>
                                                </div>
                                        </div>
                                        <div class="wpie_export_field_editor_container">
                                                <div class="wpie_export_field_editor_other_data">

                                                        <div class="wpie_export_php_fun_wrapper">
                                                                <input type="checkbox" class="wpie_checkbox wpie_export_php_fun" id="wpie_export_php_fun" name="wpie_export_php_fun" value="1"/>
                                                                <label for="wpie_export_php_fun" class="wpie_checkbox_label"><?php esc_html_e( 'Export the value returned by a PHP function', 'vj-wp-import-export' ); ?></label>
                                                        </div>
                                                        <div class="wpie_export_php_fun_inner_wrapper">
                                                                <span>&lt;?php </span>
                                                                <span><input type="text" class="wpie_content_data_small_input wpie_export_php_fun_data" id="wpie_export_php_fun_data" name="wpie_export_php_fun_data" value=""/></span>
                                                                <span> ( $value ); ?&gt;</span>
                                                        </div>
                                                </div>
                                        </div>
                                </div>
                        </div>
                        <div class="modal-footer">
                                <div class="wpie_btn wpie_btn_secondary wpie_btn_radius wpie_export_cancel_field_btn" data-dismiss="modal">
                                        <i class="fas fa-times wpie_general_btn_icon " aria-hidden="true"></i><?php esc_html_e( 'Cancel', 'vj-wp-import-export' ); ?>
                                </div>
                                <div class="wpie_btn wpie_btn_secondary wpie_btn_radius wpie_export_save_field_btn">
                                        <i class="fas fa-check wpie_general_btn_icon " aria-hidden="true"></i><?php esc_html_e( 'Save', 'vj-wp-import-export' ); ?>
                                </div>
                        </div>
                </div>
        </div>
</div>
<div class="modal fade wpie_bulk_fields_model" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                        <div class="modal-header">
                                <h5 class="modal-title"><?php esc_html_e( 'Add Fields', 'vj-wp-import-export' ); ?></h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <i class="fas fa-times wpie_general_btn_icon " aria-hidden="true"></i>
                                </button>
                        </div>
                        <div class="modal-body">
                                <div class="wpie_export_field_editor_wrapper">
                                        <div class="wpie_export_field_editor_container">
                                                <div class="wpie_export_field_editor_title"><?php esc_html_e( 'Select Fields', 'vj-wp-import-export' ); ?></div>
                                                <div class="wpie_export_fields_hint"><?php esc_html_e( 'Use Ctrl + Click to Select Multiple Fields', 'vj-wp-import-export' ); ?></div>
                                                <div class="wpie_export_field_editor_data_wrapper wpie_content_data_wrapper">
                                                        <select class="wpie_content_data_select wpie_bulk_fields" multiple="multiple">
                                                        </select>
                                                </div>
                                        </div>                   
                                </div>
                        </div>
                        <div class="modal-footer">
                                <div class="wpie_btn wpie_btn_secondary wpie_btn_radius wpie_cancel_bulk_field_btn" data-dismiss="modal">
                                        <i class="fas fa-times wpie_general_btn_icon " aria-hidden="true"></i><?php esc_html_e( 'Cancel', 'vj-wp-import-export' ); ?>
                                </div>
                                <div class="wpie_btn wpie_btn_secondary wpie_btn_radius wpie_add_bulk_field_btn">
                                        <i class="fas fa-check wpie_general_btn_icon " aria-hidden="true"></i><?php esc_html_e( 'Add', 'vj-wp-import-export' ); ?>
                                </div>
                        </div>
                </div>
        </div>
</div>
<div class="modal fade wpie_error_model" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered " role="document">
                <div class="modal-content wpie_error">
                        <div class="modal-header">
                                <h5 class="modal-title"><?php esc_html_e( 'ERROR', 'vj-wp-import-export' ); ?></h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <i class="fas fa-times wpie_general_btn_icon " aria-hidden="true"></i>
                                </button>
                        </div>
                        <div class="modal-body">
                                <div class="wpie_error_content"></div>
                        </div>
                        <div class="modal-footer">
                                <div class="wpie_btn wpie_btn_red wpie_btn_radius " data-dismiss="modal">
                                        <i class="fas fa-check wpie_general_btn_icon " aria-hidden="true"></i><?php esc_html_e( 'Ok', 'vj-wp-import-export' ); ?>
                                </div>
                        </div>
                </div>
        </div>
</div>
<div class="modal fade wpie_strict_error_model" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered " role="document">
                <div class="modal-content wpie_error">
                        <div class="modal-header">
                                <h5 class="modal-title"><?php esc_html_e( 'Permission Required', 'vj-wp-import-export' ); ?></h5>                            
                        </div>
                        <div class="modal-body">
                                <div class="wpie_strict_error_content"></div>
                        </div>                        
                </div>
        </div>
</div>
<div class="modal fade wpie_preview_model" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                        <div class="modal-header">
                                <h5 class="modal-title"><?php esc_html_e( 'Preview', 'vj-wp-import-export' ); ?></h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <i class="fas fa-times wpie_general_btn_icon " aria-hidden="true"></i>
                                </button>
                        </div>
                        <div class="modal-body">
                                <div class="wpie_preview_wrapper">
                                        <table class="wpie_preview table table-bordered" cellspacing="0"></table>
                                </div>
                        </div>
                </div>
        </div>
</div>
<div class="modal fade wpie_export_popup_wrapper" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                        <div class="modal-header">
                                <h5 class="modal-title wpie_export_proccess_title" ><?php esc_html_e( 'Export In Process', 'vj-wp-import-export' ); ?></h5>
                        </div>
                        <div class="modal-body">
                                <div class="wpie_process_bar_inner_wrapper">
                                        <div class="wpie_export_notice"><?php esc_html_e( 'Exporting may take some time. Please do not close your browser or refresh the page until the process is complete.', 'vj-wp-import-export' ); ?></div>
                                        <div class="progress wpie_export_process">
                                                <div class="progress-bar progress-bar-striped progress-bar-animated wpie_export_process_per" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">0%</div>
                                        </div>
                                        <div class="wpie_export_time_elapsed"><div class="wpie_export_time_elapsed_label"><?php esc_html_e( 'Time Elapsed', 'vj-wp-import-export' ); ?></div><div class="wpie_export_time_elapsed_value">00:00:00</div></div>
                                        <div class="wpie_export_total_records_wrapper">
                                                <div class="wpie_export_total_records">
                                                        <div class="wpie_export_total_records_label"><?php esc_html_e( 'Exported', 'vj-wp-import-export' ); ?></div>
                                                        <div class="wpie_export_total_records_value">0</div>
                                                        <div class="wpie_export_total_records_label"><?php esc_html_e( 'of', 'vj-wp-import-export' ); ?></div>
                                                        <span class="wpie_total_records wpie_export_total_records_count"></span></div>
                                        </div>
                                </div>
                                <?php if ( !empty( $wpie_remote_data ) ) {

                                        ?>
                                        <div class="wpie_remote_export_wrapper">
                                                <div class="wpie_remote_export_title"><?php esc_html_e( 'Send Exported Data To', 'vj-wp-import-export' ); ?></div>
                                                <table class="wpie_remote_export_table table table-borderedtable table-bordered">
                                                    <?php foreach ( $wpie_remote_data as $remote_key => $remote_data ) {

                                                            ?>
                                                                <tr>
                                                                        <td>
                                                                                <input type="checkbox" class="wpie_checkbox" id="wpie_remote_export_dropbox" name="wpie_remote_exported_data[]" value="<?php echo esc_attr( $remote_key ); ?>"/>
                                                                                <label for="wpie_remote_export_dropbox" class="wpie_checkbox_label"><?php echo isset( $remote_data[ 'label' ] ) ? esc_html( $remote_data[ 'label' ] ) : ""; ?></label>
                                                                        </td>
                                                                        <td>
                                                                                <div class="wpie_content_data_wrapper">
                                                                                        <select class="wpie_content_data_select" name="wpie_export_type" multiple="multiple">
                                                                                            <?php $remote_options = isset( $remote_data[ 'data' ] ) ? $remote_data[ 'data' ] : array(); ?>
                                                                                            <?php if ( !empty( $remote_options ) ) {

                                                                                                    ?>                       
                                                                                                    <?php foreach ( $remote_options as $option_key => $option_data ) {

                                                                                                            ?>
                                                                                                                <option value="<?php echo esc_attr( $option_key ); ?>"><?php echo isset( $option_data[ 'wpie_export_ext_label' ] ) ? esc_html( $option_data[ 'wpie_export_ext_label' ] ) : ""; ?></option>
                                                                                                        <?php } ?>
                                                                                                <?php } ?>
                                                                                                <?php unset( $remote_options ); ?>
                                                                                        </select>
                                                                                </div>
                                                                        </td>
                                                                </tr>
                                                        <?php } ?>
                                                </table>
                                                <div class="wpie_send_remote_data_wrapper">
                                                        <div class="wpie_btn wpie_btn_primary wpie_send_remote_data">
                                                                <i class="fas fa-play wpie_general_btn_icon " aria-hidden="true"></i><?php esc_html_e( 'Send', 'vj-wp-import-export' ); ?>
                                                        </div>
                                                </div>
                                        </div>
                                <?php } ?>
                        </div>
                        <div class="modal-footer">
                                <div class="wpie_export_process_option_btn_wrapper">
                                        <div class="wpie_btn wpie_btn_primary wpie_export_process_pause_btn wpie_export_process_btn">
                                                <i class="fas fa-pause wpie_general_btn_icon " aria-hidden="true"></i><?php esc_html_e( 'Pause', 'vj-wp-import-export' ); ?>
                                        </div>
                                        <div class="wpie_btn wpie_btn_primary wpie_export_process_stop_btn wpie_export_process_btn">
                                                <i class="fas fa-stop wpie_general_btn_icon " aria-hidden="true"></i><?php esc_html_e( 'Stop', 'vj-wp-import-export' ); ?>
                                        </div>
                                        <div class="wpie_btn wpie_btn_primary wpie_export_process_resume_btn wpie_export_process_btn">
                                                <i class="fas fa-play wpie_general_btn_icon " aria-hidden="true"></i><?php esc_html_e( 'Resume', 'vj-wp-import-export' ); ?>
                                        </div>
                                        <?php
                                        if ( !empty( $extension_process_btn ) ) {
                                                foreach ( $extension_process_btn as $ext_p_btn ) {
                                                        if ( file_exists( $ext_p_btn ) ) {
                                                                include $ext_p_btn;
                                                        }
                                                }
                                        }

                                        ?>
                                </div>
                                <div class="wpie_export_process_btn_wrapper ">
                                        <div class="wpie_btn wpie_btn_primary wpie_export_process_close_btn wpie_export_process_btn">
                                                <i class="fas fa-times wpie_general_btn_icon " aria-hidden="true"></i><?php esc_html_e( 'Close', 'vj-wp-import-export' ); ?>
                                        </div>
                                        <a class="wpie_btn wpie_btn_primary wpie_export_process_btn wpie_export_manage_export_btn" href="<?php echo admin_url( "admin.php?page=wpie-manage-export" ); ?>">
                                                <i class="fas fa-cogs wpie_general_btn_icon " aria-hidden="true"></i><?php esc_html_e( 'Manage Export', 'vj-wp-import-export' ); ?>
                                        </a>
                                        <div class="wpie_btn wpie_btn_primary wpie_export_download_btn wpie_export_process_btn">
                                                <i class="fas fa-download wpie_general_btn_icon " aria-hidden="true"></i><?php esc_html_e( 'Download', 'vj-wp-import-export' ); ?>
                                        </div>
                                </div>
                        </div>
                </div>
        </div>
</div>
<div class="modal fade wpie_process_action" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                        <div class="modal-header">
                                <h5 class="modal-title wpie_export_proccess_title" ><?php esc_html_e( 'Please Wait', 'vj-wp-import-export' ); ?></h5>
                        </div>
                        <div class="modal-body">
                                <div class="wpie_process_action_msg"><?php esc_html_e( 'Pause Exporting may take some time. Please do not close your browser or refresh the page until the process is complete.', 'vj-wp-import-export' ); ?></div>
                        </div>
                </div>
        </div>
</div>
<div class="modal fade wpie_processing_data" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                        <div class="modal-header">
                                <h5 class="modal-title wpie_import_proccess_title" ><?php esc_html_e( 'Please Wait until process is complete', 'vj-wp-import-export' ); ?></h5>
                        </div>
                        <div class="modal-body">
                                <div class="wpie_task_list"></div>
                        </div>
                </div>
        </div>
</div>
<?php
unset( $export_type, $wpie_taxonomies_list, $advance_options, $extension_html_files, $extension_process_btn, $wpie_remote_data );
