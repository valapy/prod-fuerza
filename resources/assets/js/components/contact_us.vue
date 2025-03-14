<template>
  <v-page>
    <div class="content-page">
      <div class="page-header">
        <h1>Contactanos</h1>
      </div>

      <div class="container align-center">
          <div class="col-md-6">
            <div
              class="alert"
              v-if="['error', 'success'].indexOf(status) > -1"
              :class="{'alert-danger': status =='error', 'alert-success': status == 'success'}"
            >{{ message }}</div>
            <form>
              <div class="form-group">
                <label>Nombre</label>
                <input
                  type="text"
                  class="form-control"
                  v-model="form.firstname"
                  :disabled="status == 'sending'"
                />
              </div>
              <div class="form-group">
                <label>Apellido</label>
                <input
                  type="text"
                  class="form-control"
                  v-model="form.lastname"
                  :disabled="status == 'sending'"
                />
              </div>
              <div class="clear"></div>
              <div class="form-group">
                <label>E-mail</label>
                <input
                  type="text"
                  class="form-control"
                  v-model="form.email"
                  :disabled="status == 'sending'"
                />
              </div>
              <div class="form-group">
                <label>Teléfono</label>
                <input
                  type="text"
                  class="form-control"
                  v-model="form.phone"
                  :disabled="status == 'sending'"
                />
              </div>
              <div class="form-group">
                <label>Mensaje</label>

                <textarea rows='6'
                  class="form-control"
                  v-model="form.message"
                  :disabled="status == 'sending'"
                ></textarea>
              </div>
              <div class="clear"></div>
                <div class="button-form-wrapper">
                <a
                  @click="submit"
                  href="javascript:;"
                  class="btn-form-send opacity"
                  v-if="status != 'sending'"
                >Enviar</a>
                <a
                  href="javascript:;"
                  class="btn-form-send opacity"
                  v-if="status == 'sending'"
                >
                  <i class="fas fa-circle-notch fa-spin" style="font-size:24px"></i>
                </a>
              </div>
            </form>
          </div>
      </div>
    </div>
  </v-page>
</template>

<script>
export default {
  data() {
    return {
      form: {
        fistname: "",
        lastname: "",
        email: "",
        phone: "",
        message: ""
      },
      message: null,
      status: null
    };
  },
  computed: {
    title() {
      return this.$parent.content["contact-us"]
        ? this.$parent.content["contact-us"].title
        : "";
    },
    content() {
      return this.$parent.content["contact-us"]
        ? this.$parent.content["contact-us"].content
        : "";
    }
  },
  methods: {
    submit() {
      this.message = null;

      var isValid = () => {
        var valid = true;
        var required_fields = [
          "firstname",
          "lastname",
          "phone",
          "email",
          "message"
        ];

        for (var i in required_fields) {
          var field = required_fields[i];
          if (this.form[field] && this.form[field].length > 0) continue;
          return false;
        }

        return valid;
      };

      if (!isValid()) {
        this.status = "error";
        this.message = "Por favor complete los campos del formulario";
        return;
      }

      this.status = "sending";

      $.ajaxSetup({
        headers: {
          "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        }
      });

      $.post("/contact", this.form, (data, textStatus) => {
        this.status = "success";
        this.message = "Su mensaje ha sido enviado";
        this.form = {
          fistname: "",
          lastname: "",
          email: "",
          phone: "",
          message: ""
        };
      }).fail(() => {
        this.status = "error";
        this.message = "Ocurrió un error, por favor inténtelo mas tarde";
      });
    }
  },
  components: {
    "v-page": require("./partials/page")
  }
};
</script>
