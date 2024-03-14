import "@/assets/css/styles.scss";
import {Montserrat} from "next/font/google";
import BootstrapClient from '@/components/BootstrapClient/BootstrapClient.jsx';
import App from "@/components/App/App";
import AuthProvider from "@/components/AuthProvider/AuthProvider";

const Font = Montserrat({ subsets: ['cyrillic-ext','latin','cyrillic'] })

export const metadata = {
  title: "Lexusalex tech",
  description: "Generated by create next app",
};

export default function RootLayout({ children }) {
  return (
    <html lang="en">
      <body className={Font.className}>
        <AuthProvider
            autorizeUrl="http:/localhost:8080/authorize"
            tokenUrl="http:/localhost:8080/token"
            clientId="frontend"
            scope="common"
            redirectUrl="/oauth"
        />
        <App>{children}</App>
        <BootstrapClient />
      </body>
    </html>
  );
}
