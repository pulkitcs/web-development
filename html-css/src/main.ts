import './style.css'
import { setupCounter } from './counter.ts'

document.querySelector<HTMLDivElement>('#app')!.innerHTML = `
  <main>
    <div class="container container1">1</div>
  </main>
`

setupCounter(document.querySelector<HTMLButtonElement>('#counter')!)
