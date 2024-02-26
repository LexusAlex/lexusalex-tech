import "@/assets/css/styles.scss";
import {Montserrat} from "next/font/google";
import BootstrapClient from '@/components/BootstrapClient/BootstrapClient.jsx';
import App from "@/components/App/App";
import {AppSessionProvider} from "@/session/app-session-provider";

const Font = Montserrat({ subsets: ['cyrillic-ext','latin','cyrillic'] })

export const metadata = {
  title: "Lexusalex tech",
  description: "Generated by create next app",
};

export default function RootLayout({ children }) {
  return (
    <html lang="en">
      <body className={Font.className}>
        <AppSessionProvider />
        <App>{children}</App>
        <BootstrapClient />
      </body>
    </html>
  );
}
