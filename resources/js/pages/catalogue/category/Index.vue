<template>
    <Head title="Categorias" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="p-4 flex h-full flex-1 flex-col gap-6 overflow-x-auto rounded-xl">
            
            <!-- Cabecera y Botón -->
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                    Catálogo de Categorías
                </h2>
                <div class="section_btns dark:border-sidebar-border">
                    <Button type="button" variant="outline" @click="openCreateModal">
                        Nueva Categoría +
                    </Button>
                </div>
            </div>

            <!-- Tabla de Categorías -->
            <div class="relative flex-1 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border bg-white dark:bg-gray-800 overflow-hidden">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400 border-b dark:border-gray-700">
                        <tr>
                            <th scope="col" class="px-6 py-3">Nombre</th>
                            <th scope="col" class="px-6 py-3">Descripción</th>
                            <th scope="col" class="px-6 py-3 text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Iteramos las categorías que envía el controlador -->
                        <tr v-for="categoria in categorias" :key="categoria.id" class="border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                {{ categoria.nombre }}
                            </td>
                            <td class="px-6 py-4">
                                {{ categoria.descripcion || 'Sin descripción' }}
                            </td>
                            <td class="px-6 py-4 text-right">
                                <button @click="openEditModal(categoria)" class="text-blue-600 dark:text-blue-500 hover:underline mr-4">
                                    Editar
                                </button>
                                <button @click="deleteCategoria(categoria.id)" class="text-red-600 dark:text-red-500 hover:underline">
                                    Eliminar
                                </button>
                            </td>
                        </tr>
                        <!-- Mensaje si no hay datos -->
                        <tr v-if="!categorias || categorias.length === 0">
                            <td colspan="3" class="px-6 py-8 text-center text-gray-500">
                                No hay categorías registradas aún. ¡Agrega la primera!
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
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
import { dashboard } from '@/routes';
import { type BreadcrumbItem } from '@/types';
import { Head, router, useForm } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import { ref } from 'vue';
import CrearEditar from './CrearEditar.vue';

const props = defineProps<{
    categorias: Array<any>;
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