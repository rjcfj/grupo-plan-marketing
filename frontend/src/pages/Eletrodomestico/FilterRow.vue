<!-- eslint-disable max-len -->
<template>
  <q-page padding>
    <div class="q-pa-md">
      <q-table title="Eletrodomesticos" :rows="eletrodomesticos" :columns="columns" row-key="name">
        <template v-slot:body-cell-marca="props">
        <q-td :props="props" class="q-gutter-sm">
          {{ props.row.marca.nome }}
        </q-td>
      </template>
      <template v-slot:body-cell-tensao="props">
        <q-td :props="props" class="q-gutter-sm">
          {{ props.row.tensao }} V
        </q-td>
      </template>
        <template v-slot:body-cell-actions="props">
          <q-td :props="props" class="q-gutter-sm">
            <q-btn icon="edit" color="info" dense size="sm" @click="handleEdit(props.row.id)" />
            <q-btn icon="delete" color="negative" dense size="sm" @click="handleDelete(props.row.id)" />
          </q-td>
        </template>
      </q-table>
      <div class="col-12 padding q-gutter-sm">
        <q-space />
        <q-btn label="Voltar" color="white" class="float-right" text-color="primary" :to="{ name: 'eletrodomestico' }" />
      </div>
    </div>
  </q-page>
</template>

<script>
import { defineComponent, ref, onMounted } from 'vue';
import { api } from 'boot/axios';
import { useRoute, useRouter } from 'vue-router';
import { useQuasar } from 'quasar';

export default defineComponent({
  name: 'IndexPage',
  setup() {
    const eletrodomesticos = ref([]);
    const columns = [
      {
        name: 'id', field: 'id', label: 'Código', sortable: true, align: 'left',
      }, {
        name: 'nome', field: 'nome', label: 'Nome', sortable: true, align: 'left',
      }, {
        name: 'marca', field: 'marca', label: 'Marca', sortable: true, align: 'left',
      }, {
        name: 'tensao', field: 'tensao', label: 'Tensão', sortable: true, align: 'left',
      }, {
        name: 'actions', field: 'actions', label: 'Ação', align: 'left',
      },
    ];
    const $router = useRouter();
    const $route = useRoute();
    const $q = useQuasar();

    const handleEdit = async (id) => {
      $router.push({ name: 'formEletrodomestico', params: { id } });
    };

    const getData = async () => {
      try {
        const { model, query } = $route.query;
        const { data } = await api.get(`eletrodomestico?${model}=${query}`);
        eletrodomesticos.value = data.list.data;
      } catch (error) {
        $q.notify({ message: 'Eletrodomestico de erro não encontrado', icon: 'close', color: 'negative' });
      }
    };

    // eslint-disable-next-line consistent-return
    const remove = async (id) => {
      try {
        const data = await api.delete(`eletrodomestico/${id}`);
        return data.data;
      } catch (error) {
        throw new Error(error);
      }
    };

    const handleDelete = async (id) => {
      try {
        $q.dialog({
          dark: true,
          title: 'Confirme',
          message: 'Deseja excluir o Eletrodomestico?',
          cancel: true,
          persistent: true,
        }).onOk(async () => {
          await remove(id);
          $q.notify({ message: 'Eletrodomestico deletado', icon: 'check', color: 'positive' });
          $router.push({ name: 'eletrodomestico' });
        });
      } catch (error) {
        $q.notify({ message: 'Erro ao excluir Eletrodomestico', icon: 'close', color: 'negative' });
      }
    };

    onMounted(() => {
      getData();
    });

    return {
      columns,
      eletrodomesticos,
      handleEdit,
      handleDelete,
    };
  },
});

</script>
