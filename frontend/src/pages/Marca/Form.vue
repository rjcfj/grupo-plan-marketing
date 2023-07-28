<!-- eslint-disable max-len -->
<template>
  <q-page padding>
    <q-form @submit="handleSubmit()" class="row q-col-gutter-sm">
      <q-input filled v-model="form.nome" label="Nome *" lazy-rules
        :rules="[val => val && val.length > 0 || 'Digite no mínimo 1 e no máximo 255 caracteres']" class="col-lg-6 col-xs-12"
        type="text" />
      <div class="col-12 q-gutter-sm">
        <q-btn label="Salvar" type="submit" color="primary" class="float-right" icon="save" @submit="handleSubmit()" />
        <q-btn label="Cancelar" color="white" class="float-right" text-color="primary" :to="{ name: 'marca' }" />
      </div>
    </q-form>
  </q-page>
</template>

<script>
import { defineComponent, ref, onMounted } from 'vue';
import { api } from 'boot/axios';
import { useQuasar } from 'quasar';
import { useRouter, useRoute } from 'vue-router';

export default defineComponent({
  name: 'FormMarca',
  setup() {
    const form = ref({
      id: '',
      nome: '',

    });
    const route = useRoute();
    const getMarcasById = async (id) => {
      try {
        const { data } = await api.get(`marca/${id}`);
        return data.list;
      } catch (error) {
        throw new Error(error);
      }
    };
    onMounted(async () => {
      if (route.params.id) {
        const response = await getMarcasById(route.params.id);
        form.value = response;
      }
    });
    const $q = useQuasar();
    const router = useRouter();

    // eslint-disable-next-line @typescript-eslint/no-shadow
    const post = async (form) => {
      try {
        const { data } = await api.post('marca', form.value);
        return data.data;
      } catch (error) {
        throw new Error(error);
      }
    };
    // eslint-disable-next-line @typescript-eslint/no-shadow
    const update = async (form) => {
      try {
        const { data } = await api.put(`marca/${route.params.id}`, form.value);
        $q.notify({ message: 'Marca atualizado', icon: 'check', color: 'positive' });
        router.push({ name: 'marca' });
        return data.data;
      } catch (error) {
        throw new Error(error);
      }
    };

    const handleSubmit = async () => {
      if (route.params.id) {
        try {
          await update(form);
        } catch (error) {
          $q.notify({ message: 'Erro Marca não atualizado', icon: 'times', color: 'negative' });
        }
      } else {
        post(form);
        $q.notify({ message: 'Marca criado', icon: 'check', color: 'positive' });
        router.push({ name: 'marca' });
      }
    };

    return {
      form,
      handleSubmit,
    };
  },
});
</script>

<style></style>
