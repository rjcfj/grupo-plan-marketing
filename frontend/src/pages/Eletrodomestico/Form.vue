<!-- eslint-disable max-len -->
<template>
  <q-page padding>
    <q-form @submit="handleSubmit()" class="row q-col-gutter-sm">
      <q-input filled v-model="form.nome" label="Nome *" lazy-rules
        :rules="[val => val && val.length > 0 || 'Digite no mínimo 1 e no máximo 255 caracteres']" class="col-lg-6 col-xs-12"
        type="text" />
      <q-input filled v-model="form.descricao" label="Descrição *" lazy-rules
        :rules="[val => val && val.length > 0 || 'Digite no mínimo 1 e no máximo 255 caracteres']" class="col-lg-6 col-xs-12"
        type="text" />
      <q-input filled v-model="form.tensao" label="Rensão *" lazy-rules
        :rules="[val => val && val.length > 3 || 'Digite no mínimo 3 caracteres']" class="col-lg-6 col-xs-12"
        type="text" />
      <q-input filled v-model="form.id_marca" label="Marca *" lazy-rules
        :rules="[val => val && val.length > 0 || 'Digite no mínimo 1 caractere']" class="col-lg-6 col-xs-12"
        type="text" />
      <div class="col-12 q-gutter-sm">
        <q-btn label="Salvar" type="submit" color="primary" class="float-right" icon="save" @submit="handleSubmit()" />
        <q-btn label="Cancelar" color="white" class="float-right" text-color="primary"
          :to="{ name: 'eletrodomestico' }" />
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
  name: 'FormEletrodomestico',
  setup() {
    const form = ref({
      id: '',
      nome: '',
      descricao: '',
      tensao: '',
      id_marca: 0,

    });
    const route = useRoute();
    const getEletrodomesticosById = async (id) => {
      try {
        const { data } = await api.get(`eletrodomestico/${id}`);
        return data.list;
      } catch (error) {
        throw new Error(error);
      }
    };
    onMounted(async () => {
      if (route.params.id) {
        const response = await getEletrodomesticosById(route.params.id);
        form.value = response;
      }
    });
    const $q = useQuasar();
    const router = useRouter();

    // eslint-disable-next-line @typescript-eslint/no-shadow
    const post = async (form) => {
      try {
        const { data } = await api.post('eletrodomestico', form.value);
        return data.data;
      } catch (error) {
        throw new Error(error);
      }
    };
    // eslint-disable-next-line @typescript-eslint/no-shadow
    const update = async (form) => {
      try {
        const { data } = await api.put(`eletrodomestico${route.params.id}`, form.value);
        $q.notify({ message: 'Eletrodomestico atualizado', icon: 'check', color: 'positive' });
        router.push({ name: 'eletrodomestico' });
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
          $q.notify({ message: 'Erro Eletrodomestico não atualizado', icon: 'times', color: 'negative' });
        }
      } else {
        post(form);
        $q.notify({ message: 'Eletrodomestico criado', icon: 'check', color: 'positive' });
        router.push({ name: 'home' });
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
