import "@/assets/css/styles.scss";
import {Montserrat} from "next/font/google";
import AuthProvider from "@/components/OAuth/Provider/AuthProvider";
import { Providers } from './providers'
import {Grid, GridItem} from "@chakra-ui/react";
import Header from "@/components/Main/Header/Header";

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
            <Grid
                gridTemplateColumns={"repeat(12, 1fr)"}
                gridTemplateRows={"4.5rem auto 4.5rem"}
                minH={'100vh'}
                gap={'5px'}
                gridTemplateAreas={{
                    base: `"h h h h h h h h h h h h"
                    ". m m m m m m m m m m ."
                    "f f f f f f f f f f f f"`,
                    sm: `"h h h h h h h h h h h h"
                    ". m m m m m m m m m m ."
                    "f f f f f f f f f f f f"`,
                    md: `"h h h h h h h h h h h h"
                    ". m m m m m m m m m m ."
                    "f f f f f f f f f f f f"`,
                    lg: `"h h h h h h h h h h h h"
                    "menu menu menu m m m m m m m m m"
                    "f f f f f f f f f f f f"`,
                    xl: `"h h h h h h h h h h h h"
                    ". menu menu m m m m m m m m ."
                    "f f f f f f f f f f f f"`
                }}

            >
                <GridItem area={'h'} border={'solid'} >
                    <Header></Header>
                </GridItem>
                <GridItem area={'menu'} border={'solid'} hideBelow={'lg'}>
                    Menu
                </GridItem>
                <GridItem area={'m'} border={'solid'}>
                    {children}
                </GridItem>
                <GridItem area={'f'} border={'solid'}>
                    Footer
                </GridItem>
            </Grid>
        </Providers>
      </body>
    </html>
  );
}
