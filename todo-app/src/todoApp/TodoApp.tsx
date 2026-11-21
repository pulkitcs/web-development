import { Fragment, useState, useRef, useCallback } from "react";
import TodoItem from "./TodoItem";

import styles from "./TodoApp.module.css";

const TodoApp: React.FC = () => {
  const [task, setTaskList] = useState<string[]>([]);
  const inputRef = useRef<null | HTMLInputElement>(null);

  const handleReset = useCallback(() => {
    setTaskList([]);
  }, [])

  const handleAdd = useCallback(() => {
    const inputValue: string | undefined = inputRef.current?.value?.trim();

    if (inputValue && !task.includes(inputValue)) {
      setTaskList((prevList) => {
        const clone = [...prevList];
        clone.push(inputValue);

        return clone;
      });
    }

    // Reset the value;
    inputRef.current!.value = '';
  }, [task]);

  const handleEdit = useCallback((index: number, value: string) => {
    setTaskList((prevList) => {
      const clone = [...prevList];
      clone[index] = value;
      return clone;
    })
  }, []);

  const handleDelete = useCallback((index: number) => {
    setTaskList(
      list => {
        const clone = [...list];
        clone.splice(index, 1);
        return clone;
      }
    );
  }, []);

  return <Fragment>
    <div className={styles.board}>
      <h1 className={styles.heading}>Grocery Shopping</h1>
      {task.length > 0 && <div className={styles.listBox}>
        {task?.map((task: string, index: number) =>
          <TodoItem key={task} deleteItem={handleDelete} editItem={handleEdit} task={task} index={index} />)}
      </div>}
      <div className={styles.inputBox}>
        <input type="text" placeholder="Add something to your list" className={styles.input} ref={inputRef} />
        <button className={styles.add} onClick={handleAdd}>Add</button>
      </div>
      {task.length > 0 && <button className={styles.deleteList} onClick={handleReset}>Delete List</button>}
    </div>
  </Fragment>
};

export default TodoApp;