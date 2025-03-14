import Vue from 'vue';

export default function(el) {
  new Vue({
    el,
    data: {
      sections: [],
    },
    methods: {
      addSection(section) {
        this.sections.push({ id: this.sections.length, section, data: [] });
        this._updateSpecs();
      },
      removeSection(i) {
        this.sections.splice(i, 1);
        this._updateSpecs();
      },
      updateSection(i, data) {
        this.$set(this.sections, i , data);
        this._updateSpecs();
      },
      _updateSpecs() {
        this.$refs.data.value = JSON.stringify(this.sections);
      }
    },
    components: {
      'v-section': require('./section'),
    },
    mounted() {
      try {
        this.sections = JSON.parse(this.$refs.data.value);
      } catch (e) { }
    }
  }); 
}