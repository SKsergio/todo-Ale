<template>
    <div v-if="open" class="modal-overlay bg-black/50">
        <div class="relative w-full max-w-md p-4 bg-white rounded-lg shadow dark:bg-gray-800">

            <div class="flex items-center justify-between p-4 border-b rounded-t dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    {{ isEditing ? 'Editar Categoría' : 'Nueva Categoría' }}
                </h3>
                <button @click="emit('close')" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                    <span class="sr-only">Cerrar modal</span>
                    &times;
                </button>
            </div>

            <form @submit.prevent="emit('submit')" class="p-4">
                <div class="grid gap-4 mb-4">
                    <div>
                        <label for="nombre" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nombre</label>
                        <input v-model="form.nombre" type="text" id="nombre" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="Ej. Pinturas en Lienzo" required>
                        <span v-if="form.errors.nombre" class="text-red-500 text-xs mt-1">{{ form.errors.nombre }}</span>
                    </div>
                    <div>
                        <label for="descripcion" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Descripción (Opcional)</label>
                        <textarea v-model="form.descripcion" id="descripcion" rows="3" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="Detalles de esta categoría..."></textarea>
                        <span v-if="form.errors.descripcion" class="text-red-500 text-xs mt-1">{{ form.errors.descripcion }}</span>
                    </div>
                </div>

                <div class="flex justify-end gap-2 mt-6">
                    <Button type="button" variant="outline" @click="emit('close')">Cancelar</Button>
                    <Button type="submit" :disabled="form.processing">
                        {{ isEditing ? 'Actualizar' : 'Guardar' }}
                    </Button>
                </div>
            </form>
            
        </div>
    </div>
</template>

<script setup lang="ts">
import { Button } from '@/components/ui/button';
import type { InertiaForm } from '@inertiajs/vue3';

interface CategoriaForm {
    nombre: string;
    descripcion: string;
}

defineProps<{
    open: boolean;
    isEditing: boolean;
    form: InertiaForm<CategoriaForm>;
}>();

const emit = defineEmits<{
    close: [];
    submit: [];
}>();
</script>

<style scoped>
.modal-overlay {
    position: fixed;
    inset: 0;
    z-index: 50;
    display: flex;
    overflow-y: auto;
    overflow-x: hidden;
    align-items: center;
    justify-content: center;
    background-color: rgb(0 0 0 / 0.5);
}
</style>