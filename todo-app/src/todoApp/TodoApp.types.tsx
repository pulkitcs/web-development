export type TodoItemTypes = {
  task: string, 
  index: number,
  deleteItem: (index: number) => void,
  editItem: (index: number, value: string) => void;
}