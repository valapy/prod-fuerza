import Vue from 'vue';

const DEFAULT_KEYS = ['button', 'color', 'text', 'text_align', 'top_line_alignment', 'video']
const TEMPLATE_FIELDS = {
  'text+image': ['color', 'image', 'text', 'text_align', 'top_line_alignment'],
  'text-over-image': ['image', 'text', 'text_align'],
  'image+button': ['button', 'image', 'text_align'],
  'video': ['video'],
};
function computedPropertyBuilder() {
  const properties = {};

  DEFAULT_KEYS.forEach(key => {
    properties[key] = {
      get() {
        return this.description[key]
      },
      set(value) {
        this.$set(this.description, key, value);
      },
    }
  });

  return properties;
}

export default function(el, name) {
  new Vue({
    el,
    data: {
      colors: [
        { label: 'Blanco', value: 'white', },
        { label: 'Gris', value: 'gray', },
        { label: 'Rojo', value: 'red', },
      ],
      description: {
        button: {
          label: null,
          url: null,
        },
        text: null,
        text_align: 'left',
        top_line_alignment: 'left',
      },
      name: null,
      template: null,
      templates: [
        { label: 'Texto + Imagen (lado a lado)', value: 'text+image', },
        { label: 'Texto sobre la imagen', value: 'text-over-image', },
        { label: 'Imagen con boton', value: 'image+button', },
        { label: 'Video', value: 'video', },
      ],
      text_editor: null,
    },
    computed: {
      ...computedPropertyBuilder(),
      allowedFields() {
        return TEMPLATE_FIELDS[this.template] || [];
      }
    },
    methods: {
      createTextEditorIfNeeded() {
        if (!this.$refs.editor) {
          setTimeout(() => this.createTextEditorIfNeeded(), 10);
          return;
        } else if (this.text_editor) return;

        this.text_editor = $(this.$refs.editor);
        // Init editor with config
        this.text_editor.trumbowyg(Object.assign({svgPath: this.svgPath}, window.trumbowygConfig));
        // Set initial value
        this.text_editor.trumbowyg('html', this.description.text);
        // Watch for further changes
        this.text_editor.on('tbwchange', this.set('text'));
        // Workaround : trumbowyg does not trigger change event on Ctrl+V
        this.text_editor.on('tbwpaste', this.set('text'));
        // Register events

        const events = ['focus', 'blur', 'change', 'resize', 'paste', 'openfullscreen', 'closefullscreen', 'close'];
        events.forEach((name) => {
          this.text_editor.on(`tbw${name}`, (...args) => {
            this.$emit(`tbw-${name}`, ...args);
          });
        });
      },
      destroyTextEditorIfPresent() {
        // Free up memory
        if (!this.text_editor) return;
        this.text_editor.trumbowyg('destroy');
        this.text_editor = null;
      },
      set(key) {
        // FIXME: If this shit is not updating check that the function `setFontSize` in `trumbowyg.fontsize.js` call `trumbowyg.syncCode()` and `trumbowyg.$c.trigger('tbwchange');`
        return (e) => {
          this.$set(this.description, key, ((e || {}).target || {}).value)
        };
      },
      showAlign() {
        return this.allowedFields.includes('text_align');
      },
      showAlignCenter() {
        return this.template !== 'text+image';
      },
      showButton() {
        return this.template === 'image+button';
      },
      showColors() {
        return this.allowedFields.includes('color');
      },
      showImage() {
        return this.allowedFields.includes('image');
      },
      showTextEditor() {
        const res = this.allowedFields.includes('text');
        res ? this.createTextEditorIfNeeded() : this.destroyTextEditorIfPresent();
        return res;
      },
      showTopLineAlignment() {
        return this.allowedFields.includes('top_line_alignment');
      },
      showVideo() {
        return this.allowedFields.includes('video');
      },
      __update() {
        const data = {};
        this.allowedFields.forEach(
          key => data[key] = this.description[key]
        );
        this.$refs.data.value = JSON.stringify(data);
        this.$refs.template.value = this.template;
      }
    },
    mounted() {
      this.$watch(
        function() {
          return [this.template, ...DEFAULT_KEYS.map(key => JSON.stringify(this.description[key]))].join('+')
        },
        this.__update
      );

      try {
        const data = JSON.parse(this.$refs.data.value);
        DEFAULT_KEYS.forEach(key => {
          if (data[key]) this.$set(this.description, key, data[key]);
        });
      } catch (e) { console.error('MOUNTED', e) }

      this.template = this.$refs.template.value;

      const templates = this.templates.map(({ value }) => value);
      if (!templates.includes(this.template)) {
        this.template = templates[0];
        this.$refs.template.value = this.template;
      }
    },
    beforeDestroy() {
      this.destroyTextEditorIfPresent();
    },
  });
}
