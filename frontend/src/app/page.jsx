'use client';

import Link from "next/link";
import {
  Button,
  Grid,
  GridItem,
  Modal, ModalBody, ModalCloseButton,
  ModalContent, ModalFooter,
  ModalHeader,
  ModalOverlay,
  Stack,
  Textarea, useDisclosure
} from "@chakra-ui/react";

export default function Home() {
  const { isOpen, onOpen, onClose } = useDisclosure()
  return (
      <main>
        <Link className="btn btn-light" href="/login">Login</Link>
        <Button onClick={onOpen}>Open Modal</Button>
        <Modal
            isCentered
            onClose={onClose}
            isOpen={isOpen}
            motionPreset='slideInBottom'
        >
          <ModalOverlay />
          <ModalContent>
            <ModalHeader>Русский текст</ModalHeader>
            <ModalCloseButton />
            <ModalBody>
              2134
            </ModalBody>
            <ModalFooter>
              <Button colorScheme='blue' mr={3} onClick={onClose}>
                Close
              </Button>
              <Button variant='ghost'>Secondary Action</Button>
            </ModalFooter>
          </ModalContent>
        </Modal>
      </main>
  );
}
