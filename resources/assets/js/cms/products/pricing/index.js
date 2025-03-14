import Vue from 'vue';

export default function(el) {
  new Vue({
    el,
    data: {
      pricing: [],
    },
    methods: {
      add(data = { id: this.pricing.length, field: '', value: '' }) {
        this.pricing.push(data);
        this.__update();
      },
      move(direction, index) {
        if (direction === 'down' && index >= this.pricing.length - 1) return;
        else if (direction === 'up' && index <= 0) return;

        const arr = [...this.pricing];
        const moveIndex = direction === 'down' ? index + 1 : index - 1;
        const moveRow = arr[index];

        arr[index] = arr[moveIndex];
        arr[moveIndex] = moveRow;

        this.pricing = arr;
      },
      remove(i) {
        this.pricing.splice(i, 1);
        this.__update();
      },
      update(i, data) {
        console.log('update', i , data);
        this.$set(this.pricing, i, data);
        this.__update();
      },
      __update() {
        this.$refs.data.value = JSON.stringify(this.pricing);
      }
    },
    components: {
      'v-row': require('./row'),
    },
    mounted() {
      try {
        this.pricing = JSON.parse(this.$refs.data.value);
      } catch (e) { }
    }
  });
}