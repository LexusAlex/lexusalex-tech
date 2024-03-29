import {Box, Grid, GridItem, SimpleGrid, Skeleton, Stack, Text} from "@chakra-ui/react";

export default function MainGrid({ children })
{
    /*
    return (
        <>
            <Grid
                gridTemplateColumns={"repeat(12, 1fr)"}
                gridTemplateRows={"50px auto 50px"}
                minH={'100vh'}
                gap={'5px'}
                gridTemplateAreas={
                    `"h h h h h h h h h h h h"
                    "menu menu m m m m m m m m m m"
                    "f f f f f f f f f f f f"`
                }

            >
                <GridItem area={'h'} border={'solid'} bg={'green.50'}>
                    Header
                </GridItem>
                <GridItem area={'menu'} border={'solid'}>
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
     */

    return (
    <SimpleGrid columns={{ base: 12, md: 1, lg: 3 }} gap={5}>
        <Box bg={'green.400'}>
            header
        </Box>
    </SimpleGrid>
    )


}