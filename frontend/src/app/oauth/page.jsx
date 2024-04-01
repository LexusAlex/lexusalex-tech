import {
    Button, ButtonGroup,
    Card,
    CardBody, CardFooter, CardHeader,
    Center, Divider,
    IconButton,
    Stat,
    StatHelpText,
    StatLabel,
    StatNumber,
    Text
} from "@chakra-ui/react";
import NextLink from "next/link";

export default function OAuth() {

    return (
        <>
            <Card align='center' variant={'outline'} size={'md'} maxW='md' justifyContent={'center'}>
                <CardBody>
                    <Text fontSize='md'>Спасибо, что залогинились</Text>
                </CardBody>
                <CardFooter>
                    <Button colorScheme='blue' as={NextLink} href="/">На главную</Button>
                </CardFooter>
            </Card>
        </>
    );
}