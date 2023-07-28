<!-- eslint-disable max-len -->
<template>
  <div class="q-pa-md">
    <q-form @submit="handleFilter(form.field, form.query)"
      class="row q-col-gutter-sm justify-center align-center q-mb-md">
      <q-select outlined dense v-model="form.field" :options="selectOptions" emit-value label="Escolha um filtro"
        class="col-lg-5 col-xs-12" type="text" />
      <q-input filled dense v-model="form.query" label="Digite" class="col-lg-5 col-xs-12" />
      <div class="row align-center  col-lg-2 col-xs-12">
        <q-btn label="Filtro" type="submit" color="primary" style="height: 40px;" />
      </div>
    </q-form>
    <q-table title="Marcas" :rows="marcas" :columns="columns" row-key="name">
      <template v-slot:top>
        <q-space />
        <q-btn color="primary" label="Adicionar" :to="{ name: 'formMarca' }" />
      </template>
      <template v-slot:body-cell-actions="props">
        <q-td :props="props" class="q-gutter-sm">
          <q-btn icon="edit" color="info" dense size="sm" @click="handleEdit(props.row.id)" />
          <q-btn icon="delete" color="negative" dense size="sm" @click="handleDelete(props.row.id)" />
        </q-td>
      </template>
    </q-table>
  </div>
</template>

<script>
import { defineComponent, ref, onMounted } from 'vue';
import { api } from 'boot/axios';
import { useQuasar } from 'quasar';
import { useRouter } from 'vue-router';

export default defineComponent({
  name: 'IndexPage',
  setup() {
    const marcas = ref([]);
    const form = ref({
      field: '',
      query: '',
    });
    const columns = [
      {
        name: 'id', field: 'id', label: 'Código', sortable: true, align: 'left',
      }, {
        name: 'nome', field: 'nome', label: 'Nome', sortable: true, align: 'left',
      }, {
        name: 'actions', field: 'actions', label: 'Ação', align: 'left',
      },
    ];
    const selectOptions = [
      { label: 'Código', value: 'id', type: 'number' },
      { label: 'Nome', value: 'nome', type: 'text' },
    ];
    const $q = useQuasar();
    const router = useRouter();

    const getData = async () => {
      try {
        const { data } = await api.get('marca');
        marcas.value = data.list.data;
      } catch (error) {
        throw new Error(error);
      }
    };
    // eslint-disable-next-line consistent-return
    const remove = async (id) => {
      try {
        const data = await api.delete(`marca/${id}`);
        return data.data;
      } catch (error) {
        throw new Error(error);
      }
    };

    const handleEdit = async (id) => {
      router.push({ name: 'formMarca', params: { id } });
    };

    const handleFilter = (model, query) => {
      router.push({ name: 'filterMarca', query: { model, query } });
    };

    const handleDelete = async (id) => {
      try {
        $q.dialog({
          dark: true,
          title: 'Confirme',
          message: 'Deseja excluir o Marca?',
          cancel: true,
          persistent: true,
        }).onOk(async () => {
          await remove(id);
          $q.notify({ message: 'Marca deletado', icon: 'check', color: 'positive' });
          await getData();
        });
      } catch (error) {
        $q.notify({ message: 'Erro ao excluir marca', icon: 'times', color: 'negative' });
      }
    };

    onMounted(() => {
      getData();
    });

    return {
      columns,
      marcas,
      form,
      selectOptions,
      handleDelete,
      handleEdit,
      handleFilter,
    };
  },
});

</script>
