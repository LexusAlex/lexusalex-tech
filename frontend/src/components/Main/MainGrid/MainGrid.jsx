import {Grid, GridItem} from "@chakra-ui/react";
import Header from "@/components/Main/Header/Header";

export default function MainGrid({ children })
{
    
    return (
        <>
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
        </>
    )


    /*
    return (
    <SimpleGrid
        columns={{ base: 3,sm: 2, md: 1, lg: 1, xl: 1, "2xl": 1}}
        spacing={3}
        minH={'100vh'}
    >
        <Box bg={'green.400'}>
            header
        </Box>
        <Box bg={'green.400'}>
            aside
        </Box>
        <Box bg={'green.400'}>
            main
        </Box>
        <Box bg={'green.400'}>
            footer
        </Box>
        <SimpleGrid
            minChildWidth="150px"
            spacing="40px"
            maxW="xl"
            alignItems="center"
            justifyContent="center"
            margin="100px auto"
        >
        </SimpleGrid>
    </SimpleGrid>
    )

     */


}