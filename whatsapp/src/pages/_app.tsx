import '@/styles/globals.css'
import styles from '@/styles/app.module.css';
import type { AppProps } from 'next/app';
import Head from 'next/head';

export default function App({ Component, pageProps }: AppProps) {
  return <>
    <Head>
      <meta name="description" content="Demo WhatsApp application created in Next.js" />
      <meta name="viewport" content='width=device-width, initial-scale=1' />
      <title>WhatsApp for web</title>
    </Head>
    <div className={styles.container}>
      <div className={styles.contentBox}>
        <Component {...pageProps} />
      </div>
    </div>
  </>
}
