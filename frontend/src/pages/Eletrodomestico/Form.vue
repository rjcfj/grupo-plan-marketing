<!-- eslint-disable max-len -->
<template>
  <q-page padding>
    <q-form @submit="handleSubmit()" class="row q-col-gutter-sm">
      <q-input filled v-model="form.nome" label="Nome *" lazy-rules
        :rules="[val => val && val.length > 0 || 'Digite no mínimo 1 e no máximo 255 caracteres']"
        class="col-lg-6 col-xs-12" type="text" />
      <q-input filled v-model="form.descricao" label="Descrição *" lazy-rules
        :rules="[val => val && val.length > 0 || 'Digite no mínimo 1 e no máximo 255 caracteres']"
        class="col-lg-6 col-xs-12" type="text" />
      <q-input filled v-model="form.tensao" label="Tensão *" lazy-rules
        :rules="[val => val && val.length > 2 || 'Digite no mínimo 3 caracteres']" class="col-lg-6 col-xs-12"
        type="text" />
      <q-select filled v-model="form.id_marca" :options="optionsMarca" label="Marca *" emit-value map-options
        :rules="[val => !!val || 'Campo é obrigatório']" options-dense class="col-lg-6 col-xs-12" />
      <div class="col-12 q-gutter-sm">
        <q-btn label="Salvar" type="submit" color="primary" class="float-right" icon="save" @submit="handleSubmit()" />
        <q-btn label="Voltar" color="white" class="float-right" text-color="primary" :to="{ name: 'eletrodomestico' }" />
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
      id_marca: '',

    });
    const optionsMarca = ref([]);
    const route = useRoute();
    const getEletrodomesticosById = async (id) => {
      try {
        const { data } = await api.get(`eletrodomestico/${id}`);
        return data.list;
      } catch (error) {
        throw new Error(error);
      }
    };
    const getMarca = async () => {
      try {
        const { data } = await api.get('marca');
        /* eslint-disable-next-line no-plusplus */
        for (let index = 0; index < data.list.data.length; index++) {
          optionsMarca.value[index] = {
            label: data.list.data[index].nome,
            value: data.list.data[index].id,
          };
        }
      } catch (error) {
        throw new Error(error);
      }
    };

    onMounted(async () => {
      getMarca();
      if (route.params.id) {
        const response = await getEletrodomesticosById(route.params.id);
        const {
          id,
          nome,
          descricao,
          tensao,
          marca,
        } = response;
        form.value.id = id;
        form.value.nome = nome;
        form.value.descricao = descricao;
        form.value.tensao = tensao;
        form.value.id_marca = { label: marca.nome, value: marca.id };
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
      const sendObject = { ...form.value };
      if (typeof form.value.id_marca === 'number') {
        sendObject.id_marca = form.value.id_marca;
      } else {
        sendObject.id_marca = form.value.id_marca.value;
      }
      try {
        const { data } = await api.put(`eletrodomestico/${route.params.id}`, sendObject);
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
        router.push({ name: 'eletrodomestico' });
      }
    };

    return {
      form,
      optionsMarca,
      handleSubmit,
    };
  },
});
</script>

<style></style>
