<template>
  <div>
    <Menubar>
    <template #end>
      <div style="position: fixed; left: 20px;">
        <Button icon="pi pi-bars" @click="visibleLeft = true"/>
      </div>
        <InputText placeholder="Search" type="text" />
        <Button label="Logout" @click.prevent="logout_user(user_token)" icon="pi pi-power-off" :style="{'margin-left': '1em'}"/>
    </template>
  </Menubar>
  <Sidebar :visible.sync="visibleLeft" :baseZIndex="1000">
    <h1 style="fontWeight:normal">User Dashboard</h1>
    <Accordion>
    <AccordionTab header="About">
        <p>The story begins as Don Vito Corleone, the head of a New York Mafia family, overseeshis daughter's wedding. His beloved son ichael has just come home from the war,
        but does not intend to become part of his father's business. Through Michael's life the nature of the family business becomes clear. The business of the family is
        just like the head of the family, kind and benevolent to those who give respect, but given to ruthless violence whenever anything stands against the good of the family.</p>
    </AccordionTab>
    <AccordionTab header="Profile">
        <p>Francis Ford Coppola's legendary continuation and sequel to his landmark 1972 film, TheGodfather parallels the young Vito Corleone's rise with his son Michael's spiritual fall,
        deepening The Godfather's depiction of the dark side of the American dream. In the early 1900s, the child Vito flees his Sicilian village for America after the local Mafia kills
        his family. Vito struggles to make a living, legally or illegally, for his wife and growing brood in Little Italy.</p>
    </AccordionTab>
    <AccordionTab header="Settings">
        <p>The Godfather Part III is set in 1979 and 1980. Michael has moved back to New York and taken great strides to remove the family from crime. He turns over his New York criminal
        interests to longtime enforcer Joey Zasa. He uses his wealth in an attempt to rehabilitate his reputation through numerous philanthropic acts, administered by a foundation named after his father.
        A decade earlier, he gave custody of his two children to Kay, who has since remarried.</p>
    </AccordionTab>
</Accordion>
  </Sidebar>
  </div>

</template>
<script>
    export default {
       /*  data() {
            return {
                items: [
                    {label: 'Home', icon: 'pi pi-fw pi-home', to: '/tabmenu'},
                    {label: 'Calendar', icon: 'pi pi-fw pi-calendar', to: '/tabmenu/calendar'},
                    {label: 'Edit', icon: 'pi pi-fw pi-pencil', to: '/tabmenu/edit'},
                    {label: 'Documentation', icon: 'pi pi-fw pi-file', to: '/tabmenu/documentation'},
                    {label: 'Settings', icon: 'pi pi-fw pi-cog', to: '/tabmenu/settings'}
                ]
            }
        } */
    }
</script>