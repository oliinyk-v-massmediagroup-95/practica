<v-navigation-drawer
    app
>
    <v-list dense>

        <sidebar-element link="{{route('user.file.index')}}" text="Files"></sidebar-element>

        <sidebar-element link="{{route('user.report.index')}}" text="Reports"></sidebar-element>

        <form id="logout-form" action="{{ url('/logout') }}" method="POST">
            {{ csrf_field() }}
            <sidebar-element onclick="document.forms['logout-form'].submit()" :link="false" text="Logout"></sidebar-element>
        </form>

    </v-list>
</v-navigation-drawer>
