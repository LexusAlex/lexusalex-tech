import {Box, Grid, GridItem, SimpleGrid} from "@chakra-ui/react";

export default function MainGrid({ children })
{
    return (
        <Grid
            templateAreas={`"header header"
                  "nav main"
                  "nav footer"`}
            gridTemplateRows={'70px 1fr 30px'}
            gridTemplateColumns={'150px 1fr'}
            h='100vh'
            w='100vw'
            gap='2'
            color='blackAlpha.700'
            fontWeight='bold'
        >
            <GridItem pl='2' bg='beige' area={'header'}>
                Header
            </GridItem>
            <GridItem pl='2' bg='beige' area={'nav'}>
                Nav
            </GridItem>
            <GridItem pl='2' bg='beige' area={'main'}>
                {children}
            </GridItem>
            <GridItem pl='2' bg='beige' area={'footer'}>
                Footer
            </GridItem>
        </Grid>
    )
}