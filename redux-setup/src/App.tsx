import { Fragment } from "react";
import AppHook from "./components/AppWithHooks";
import AppClass from "./components/AppWithClass";
import Counter from "./components/Counter"

export default function App(): React.ReactNode {
  return <Fragment>
    <AppHook />
    <AppClass />
    <Counter initial={5} />
  </Fragment>
}