<template>
    <Head title="Categorias" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="p-4 flex h-full flex-1 flex-col gap-6 overflow-x-auto rounded-xl">
            
            <!-- Cabecera y Botón -->
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                    Productos
                </h2>
                <div class="section_btns dark:border-sidebar-border">
                    <Button type="button" variant="outline" @click="openCreateModal">
                        Nuevo Producto +
                    </Button>
                </div>
            </div>

            <!-- Tabla de Categorías -->
            <!-- <div class="table-wrapper">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Id</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Descripción</th>
                            <th scope="col" class="th--end">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="categoria in categorias.data" :key="categoria.id">
                            <td class="td--strong">
                                {{ categoria.id }}
                            </td>
                            <td class="td--strong">
                                {{ categoria.nombre }}
                            </td>
                            <td>
                                {{ categoria.descripcion || 'Sin descripción' }}
                            </td>
                            <td class="td--end">
                                <button @click="openEditModal(categoria)" class="action-link">
                                    Editar
                                </button>
                                <button @click="deleteCategoria(categoria.id)" class="action-link action-link--danger">
                                    Eliminar
                                </button>
                            </td>
                        </tr>
                        <tr v-if="categorias.data.length === 0">
                            <td colspan="4" class="table-empty">
                                No hay categorías registradas aún. ¡Agrega la primera!
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div> -->

            <Pagination
                :links="categorias.links"
                :from="categorias.from"
                :to="categorias.to"
                :total="categorias.total"
            />
        </div>

        <CrearEditar
            :open="isOpen"
            :is-editing="isEditing"
            :form="form"
            @close="closeModal"
            @submit="submit"
        />
    </AppLayout>
</template>

<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import Pagination from '@/components/Pagination.vue';
import { dashboard } from '@/routes';
import { type BreadcrumbItem, type Paginated } from '@/types';
import { Head, router, useForm } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import { ref } from 'vue';
import CrearEditar from './CrearEditar.vue';
import { CatalogueInterface } from '@/types/catalogue/CatalogueInterface.js';

const props = defineProps<{
    categorias: Paginated<CatalogueInterface>;
}>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Categorias',
        href: dashboard().url,
    },
];

const isOpen = ref(false);
const isEditing = ref(false);
const editingId = ref<number | null>(null);

const form = useForm({
    nombre: '',
    descripcion: '',
});


const openCreateModal = () => {
    isEditing.value = false;
    editingId.value = null;
    form.reset();
    form.clearErrors();
    isOpen.value = true;
};

const openEditModal = (categoria: any) => {
    isEditing.value = true;
    editingId.value = categoria.id;
    form.nombre = categoria.nombre;
    form.descripcion = categoria.descripcion;
    form.clearErrors();
    isOpen.value = true;
};

const closeModal = () => {
    isOpen.value = false;
    form.reset();
    form.clearErrors();
};

const submit = () => {
    if (isEditing.value && editingId.value) {
        form.put(`/categorias/${editingId.value}`, {
            preserveScroll: true,
            onSuccess: () => closeModal(),
        });
    } else {
        form.post('/categorias', {
            preserveScroll: true,
            onSuccess: () => closeModal(),
        });
    }
};

const deleteCategoria = (id: number) => {
    if (confirm('¿Estás seguro de eliminar esta categoría?')) {
        router.delete(`/categorias/${id}`, {
            preserveScroll: true,
        });
    }
};
</script>

<style>
.continer_main {
    display: flex;
    flex-direction: column;
    width: 100%;
    height: 100%;
    gap: 20px;
    padding: 20px;
    overflow-x: auto;
    border-radius: 10px;
}

.ejemplo {
    display: flex;
    flex-direction: row;
    justify-content: flex-end;
    height: 10%;
    padding: 2px;
}

.section_btns {
    display: flex;
    padding: 10px;

}
</style>