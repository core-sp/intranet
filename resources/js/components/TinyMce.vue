<template>
    <div>
        <editor
            api-key="r4mn0lwo1bqizx4qx5y71gn825etof3nqccvy4svo1lhn72k"
            :init="{
                selector: 'textarea',
                plugins: 'link table paste',
                menubar: 'format insert table',
                language_url: '/translations/pt_BR.js',
                a_plugin_option: true,
                a_configuration_option: 400,
                table_default_attributes: {
                    border: '1'
                },
                table_default_styles: {
                    'border-collapse': 'collapse',
                },
                theme_advanced_resizing : true,
                theme_advanced_resize_horizontal : false,
                entity_encoding : 'numeric'
            }"
            name="content"
            id="content"
            rows="15"
            placeholder="Conteúdo do chamado"
            class="form-control textarea-content"
        ></editor>
    </div>
</template>

<script>
    var Editor = require('@tinymce/tinymce-vue').default;

    export default {
        components: {
            'editor': Editor
        },
    }
</script>