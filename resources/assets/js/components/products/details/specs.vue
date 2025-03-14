<template>
  <div>
    <div class="description background-gray">
      <div class="grid-container">
        <div v-for="row of product.specs" :key="row.section" class="grid-item">
          <h2>
            <div class="line"></div>
            {{ row.section }}
          </h2>
          <table class="table table-striped table-hover table-sm">
            <tbody>
              <tr v-for="{ field, value } of row.data" :key="`${field}-${value}`">
                <td>{{ field }}</td>
                <td>{{ value }}</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

      <div v-if="product.pdf" class="catalog">
        <a
          class="btn btn-danger text-center"
          :href="`/${product.pdf}`"
          target="_blank"
        >Descargar catálogo</a>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ["product"]
};
</script>