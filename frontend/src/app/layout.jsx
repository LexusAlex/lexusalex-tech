import "@/assets/css/styles.scss";
import {Montserrat} from "next/font/google";
import AuthProvider from "@/components/OAuth/Provider/AuthProvider";
import { Providers } from './providers'
import Application from "@/components/Main/Application/Application";

const Font = Montserrat({ subsets: ['cyrillic-ext','latin','cyrillic'] })

export const metadata = {
  title: "Lexusalex tech",
  description: "Система для управления своим временем",
};

export default function RootLayout({ children }) {
  return (
    <html lang="en">
      <body className={Font.className}>
        <AuthProvider></AuthProvider>
        <Providers>
            <Application>{children}</Application>
        </Providers>
      </body>
    </html>
  );
}
