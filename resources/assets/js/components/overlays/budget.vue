<template>
  <div class="overlay">
    <div class="content">
      <div class="logo">
        <img src="/img/btn-budget.svg" alt="Presupuesto" />
        <h1>Solicitá tu presupuesto</h1>
      </div>
      <div
        class="alert"
        v-if="['error', 'success'].indexOf(status) > -1"
        :class="{'alert-danger': status =='error', 'alert-success': status == 'success'}"
      >{{ message }}</div>
      <form method="POST">
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label>Sucursal mas cercana</label>
              <select v-model="form.office_id" class="form-control" :disabled="status == 'sending'">
                <option v-for="row in branch_offices" :value="row.id" :key="row.id">{{row.name}}</option>
              </select>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label>Ciudad</label>
              <input type="text" v-model="form.city" :disabled="status == 'sending'" />
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label>Nombre</label>
              <input type="text" v-model="form.firstname" :disabled="status == 'sending'" />
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label>Apellido</label>
              <input type="text" v-model="form.lastname" :disabled="status == 'sending'" />
            </div>
          </div>
        </div>
        <div class="clear"></div>
        <div class="form-group">
          <label>Producto de interés</label>
          <input type="text" v-model="form.product_of_interest" :disabled="status == 'sending'" />
        </div>
        <div class="clear"></div>
        <div class="form-group">
          <label>Medio por el que prefiero ser contactado</label>
          <ul class="no-list inline-list">
            <li>
              <input
                type="radio"
                id="phone"
                value="phone"
                v-model="form.contact_method"
                :checked="form.contact_method == 'phone'"
                :disabled="status == 'sending'"
              />
              <label for="phone">
                <span></span>Teléfono
              </label>
            </li>
            <li>
              <input
                type="radio"
                id="email"
                value="email"
                v-model="form.contact_method"
                :checked="form.contact_method == 'email'"
                :disabled="status == 'sending'"
              />
              <label for="email">
                <span></span>Correo electrónico
              </label>
            </li>
            <li>
              <input
                type="radio"
                id="whatsapp"
                value="whatsapp"
                v-model="form.contact_method"
                :checked="form.contact_method == 'whatsapp'"
                :disabled="status == 'sending'"
              />
              <label for="whatsapp">
                <span></span>Whatsapp
              </label>
            </li>
          </ul>
          <input
            type="text"
            v-model="form.contact_value"
            placeholder="Teléfono"
            v-if="form.contact_method == 'phone'"
            :disabled="status == 'sending'"
          />
          <input
            type="text"
            v-model="form.contact_value"
            placeholder="Correo electrónico"
            v-if="form.contact_method == 'email'"
            :disabled="status == 'sending'"
          />
          <input
            type="text"
            v-model="form.contact_value"
            placeholder="Número de Whatsapp"
            v-if="form.contact_method == 'whatsapp'"
            :disabled="status == 'sending'"
          />
        </div>
        <div class="clear"></div>
        <div class="form-group">
          <label>Mensaje Adicional</label>
          <textarea v-model="form.message" :disabled="status == 'sending'"></textarea>
        </div>
        <div>
          <a
            @click="submit"
            href="javascript:;"
            class="btn btn-submit btn-red float-right opacity"
            v-if="status != 'sending'"
          >Enviar</a>
          <a
            @click="$emit('close')"
            href="javascript:;"
            class="btn float-right opacity"
            v-if="status != 'sending'"
          >Cerrar</a>
          <a
            href="javascript:;"
            class="btn btn-submit btn-red float-right opacity"
            v-if="status == 'sending'"
          >
            <i class="fas fa-circle-notch fa-spin" style="font-size:24px"></i>
          </a>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      form: {
        office_id: 0,
        firstname: "",
        lastname: "",
        city: "",
        product_of_interest: "",
        contact_method: "phone",
        contact_value: "",
        message: ""
      },
      message: null,
      status: null
    };
  },
  computed: {
    branch_offices() {
      return this.$parent.branch_offices || [];
    }
  },
  props: [],
  methods: {
    submit() {
      this.message = null;

      var isValid = () => {
        var valid = true;
        var required_fields = Object.keys(this.form);

        for (var i in required_fields) {
          var field = required_fields[i];
          if (this.form[field] && (this.form[field] + "").length > 0) continue;
          console.log(field);
          return false;
        }

        return valid;
      };

      if (!isValid()) {
        this.status = "error";
        this.message = "Por favor complete todos los campos del formulario";
        return;
      }

      this.status = "sending";

      $.ajaxSetup({
        headers: {
          "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        }
      });

      $.post("/budgets", this.form, (data, textStatus) => {
        this.status = "success";
        this.message = "Su pedido de presupeusto ha sido enviado";
      }).fail(() => {
        this.status = "error";
        this.message = "Ocurrió un error, por favor inténtelo mas tarde";
      });

      this.$emit("close");

      window.dataLayer = window.dataLayer || [];
      window.dataLayer.push({
      'event': 'popinSubmit'
      });

    },
    keybind(e) {
      if (e.keyCode === 27) this.$emit("close");
    }
  },
  mounted() {
    document.body.addEventListener("keyup", this.keybind);
    if (this.$parent.current_product)
      this.form.product_of_interest = this.$parent.current_product.model;
  },
  beforeDestroy() {
    document.body.removeEventListener("keyup", this.keybind);
  }
};
</script>
