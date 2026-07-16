export interface CatalogueInterface {
    readonly id: number;
    nombre: string;
    descripcion: string | null;
}

export interface CatalogueRequestInterface extends Omit<CatalogueInterface, 'id'>  {
}